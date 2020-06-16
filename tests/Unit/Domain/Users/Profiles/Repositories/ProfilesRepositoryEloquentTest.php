<?php

namespace Tests\Unit\Domain\Users\Profiles\Repositories;

use Illuminate\Support\Collection;
use template\Domain\Users\Profiles\Events\ProfileUpdatedEvent;
use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;

class ProfilesRepositoryEloquentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var ProfilesRepositoryEloquent|null
     */
    protected $rProfiles = null;

    public function __construct()
    {
        parent::__construct();

        $this->rProfiles = app()->make(ProfilesRepositoryEloquent::class);
    }

    public function testCheckIfRepositoryIsCorrectlyInstantiated()
    {
        $this->assertTrue($this->rProfiles instanceof ProfilesRepositoryEloquent);
    }

    public function testModel()
    {
        $this->assertEquals(Profile::class, $this->rProfiles->model());
    }

    public function testCreate()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->raw(['user_id' => $user->id]);
        $profile = $this->rProfiles->create($profile);
        $this->assertDatabaseHas('users_profiles', $profile->toArray());
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);
        $newProfile = factory(Profile::class)->raw(['user_id' => $user->id]);
        Event::fake();
        $profile = $this->rProfiles->update($newProfile, $profile->id);
        Event::assertDispatched(ProfileUpdatedEvent::class, function ($event) use ($profile) {
            return $event->profile->id === $profile->id;
        });
        $this->assertDatabaseHas('users_profiles', $profile->toArray());
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create(['user_id' => $user->id]);
        $profileId = $this->rProfiles->delete($profile->id);
        $this->assertEquals($profile->id, $profileId);
    }

    public function testGetFamilySituationsList()
    {
        $this->assertEquals(
            new Collection(Profile::FAMILY_SITUATIONS),
            $this->rProfiles->getFamilySituations()
        );
    }
}
