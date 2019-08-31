<?php namespace Tests\Unit\Domain\Users\Profiles\Repositories;

use obsession\Domain\Users\Profiles\Events\ProfileUpdatedEvent;
use obsession\Domain\Users\Profiles\Profile;
use obsession\Domain\Users\Users\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use obsession\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;

class ProfilesRepositoryEloquentTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @var ProfilesRepositoryEloquent|null
     */
    protected $r_profiles = null;

    public function __construct()
    {
        parent::__construct();

        $this->r_profiles = app()->make(ProfilesRepositoryEloquent::class);
    }

    public function testCheckIfRepositoryIsCorrectlyInstantiated()
    {
        $this->assertTrue($this->r_profiles instanceof ProfilesRepositoryEloquent);
    }


    public function testModel()
    {
        $this->assertEquals(Profile::class, $this->r_profiles->model());
    }

    public function testCreate()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->raw(['user_id' => $user->id]);
        $profile = $this->r_profiles->create($profile);
        $this->assertDatabaseHas('users_profiles', $profile->toArray());
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);
        $newProfile = factory(Profile::class)->raw(['user_id' => $user->id]);
        Event::fake();
        $profile = $this->r_profiles->update($newProfile, $profile->id);
        Event::assertDispatched(ProfileUpdatedEvent::class, function ($event) use ($profile) {
            return $event->profile->id === $profile->id;
        });
        $this->assertDatabaseHas('users_profiles', $profile->toArray());
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);
        $profileId = $this->r_profiles->delete($profile->id);
        $this->assertEquals($profile->id, $profileId);
    }

    public function testGetFamilySituationsList()
    {
        $this->assertEquals([
            Profile::FAMILY_SITUATION_SINGLE,
            Profile::FAMILY_SITUATION_MARRIED,
            Profile::FAMILY_SITUATION_CONCUBINAGE,
            Profile::FAMILY_SITUATION_DIVORCEE,
            Profile::FAMILY_SITUATION_WIDOW_ER,
        ], $this->r_profiles->getFamilySituationsList()->keys()->toArray());
    }
}
