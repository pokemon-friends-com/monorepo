<?php namespace Tests\Unit\Domain\Users\Users\Repositories;

use template\Domain\Users\Users\Events\UserCreatedEvent;
use template\Domain\Users\Users\Events\UserDeletedEvent;
use template\Domain\Users\Users\Events\UserRefreshSessionEvent;
use template\Domain\Users\Users\Events\UserTriedToDeleteHisOwnAccountEvent;
use template\Domain\Users\Users\Events\UserUpdatedEvent;
use template\Domain\Users\Users\Notifications\CreatedAccountByAdministrator;
use template\Domain\Users\Users\Transformers\UsersListTransformer;
use template\Domain\Users\Users\User;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UsersRepositoryEloquentTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    public function __construct()
    {
        parent::__construct();

        $this->r_users = app()->make(UsersRepositoryEloquent::class);
    }

    public function testCheckIfRepositoryIsCorrectlyInstantiated()
    {
        $this->assertTrue($this->r_users instanceof UsersRepositoryEloquent);
    }

    public function testModel()
    {
        $this->assertEquals(User::class, $this->r_users->model());
    }

    public function testCreate()
    {
        /*
         * The raw user have uniqid and password.
         */
        $rawUser = factory(User::class)->raw();
        Event::fake();
        $user = $this->r_users->create($rawUser);
        Event::assertDispatched(UserCreatedEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        $this->assertDatabaseHas('users', $user->toArray());
        /*
         * The raw user have not uniqid and password.
         */
        $rawUser = factory(User::class)->states(['password_null', 'uniqid_null'])->raw();
        Event::fake();
        $user = $this->r_users->create($rawUser);
        Event::assertDispatched(UserCreatedEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        $this->assertDatabaseHas('users', $user->toArray());
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $rawUser = factory(User::class)->raw();
        Event::fake();
        $user = $this->r_users->update($rawUser, $user->id);
        Event::assertDispatched(UserUpdatedEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        $userArr = $user->toArray();
        Arr::forget($userArr, 'updated_at');
        Arr::forget($userArr, 'profile');
        $this->assertDatabaseHas('users', $userArr);
    }

    public function testDelete()
    {
        $user = factory(User::class)->create();
        Event::fake();
        $user = $this->r_users->delete($user->id);
        Event::assertDispatched(UserDeletedEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        $userArr = $user->toArray();
        Arr::forget($userArr, 'profile');
        $this->assertDatabaseHas('users', $userArr);
        $this->assertSoftDeleted('users', $userArr);
    }

    public function testRefreshSession()
    {
        $user = factory(User::class)->create();

        Event::fake();
        $this
            ->r_users
            ->refreshSession($user);
        Event::assertDispatched(UserRefreshSessionEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    public function testRoles()
    {
        $this->assertEquals(
            [
                User::ROLE_ADMINISTRATOR,
                User::ROLE_ACCOUNTANT,
                User::ROLE_CUSTOMER
            ],
            $this->r_users->getRoles()->keys()->toArray()
        );
    }

    public function testCivilities()
    {
        $this->assertEquals(
            [
                User::CIVILITY_MADAM,
                User::CIVILITY_MISS,
                User::CIVILITY_MISTER
            ],
            $this->r_users->getCivilities()->keys()->toArray()
        );
    }

    public function testLocales()
    {
        $this->assertEquals(User::LOCALES, $this->r_users->getLocales()->toArray());
    }

    public function testTimezones()
    {
        $this->assertEquals(timezones(), $this->r_users->getTimezones()->toArray());
    }

    public function testAllWithTrashed()
    {
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->states('deleted')->create();

        $this->assertEquals(3, $this->r_users->allWithTrashed()->count());
    }

    public function testOnlyTrashed()
    {
        factory(User::class)->create();
        factory(User::class)->create();
        factory(User::class)->states('deleted')->create();

        $this->assertEquals(1, $this->r_users->onlyTrashed()->count());
    }

    public function testFilterByUniqueId()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->states('deleted')->create();

        $repositoryUser = $this
            ->r_users
            ->skipPresenter()
            ->filterByUniqueId($user->uniqid)
            ->get();

        $this->assertEquals(1, $repositoryUser->count());
        $this->assertEquals($user->uniqid, $repositoryUser->first()->uniqid);
    }

    public function testFilterByUniqueIdDifferentThan()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->states('deleted')->create();

        $repositoryUser = $this
            ->r_users
            ->skipPresenter()
            ->filterByUniqueIdDifferentThan($user->uniqid)
            ->get();

        $this->assertEquals(1, $repositoryUser->count());
        $this->assertNotEquals($user, $repositoryUser->first());
    }

    public function testFilterByName()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->states('deleted')->create();

        $repositoryUser = $this
            ->r_users
            ->skipPresenter()
            ->filterByName($user->first_name)
            ->get();

        $this->assertEquals(1, $repositoryUser->count());
        $this->assertEquals($user->full_name, $repositoryUser->first()->full_name);
    }

    public function testFilterByEmail()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->states('deleted')->create();

        $repositoryUser = $this
            ->r_users
            ->skipPresenter()
            ->filterByEmail($user->email)
            ->get();

        $this->assertEquals(1, $repositoryUser->count());
        $this->assertEquals($user->email, $repositoryUser->first()->email);
    }

    public function testCreateUser()
    {
        Notification::fake();
        Event::fake();
        /*
         * Create new user without to specify the optionals parameters.
         */
        $rawUser = factory(User::class)->raw();
        $user = $this->r_users->createUser(
            $rawUser['civility'],
            $rawUser['first_name'],
            $rawUser['last_name'],
            $rawUser['email']
        );
        Event::assertDispatched(UserCreatedEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        Notification::assertSentTo($user, CreatedAccountByAdministrator::class);
        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('users_profiles', ['user_id' => $user->id]);
        /*
         * Create new user with the optionals parameters.
         */
        $rawUser = factory(User::class)->raw();
        $user = $this->r_users->createUser(
            $rawUser['civility'],
            $rawUser['first_name'],
            $rawUser['last_name'],
            $rawUser['email'],
            $rawUser['role'],
            $rawUser['locale'],
            $rawUser['timezone']
        );
        Event::assertDispatched(UserCreatedEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        Notification::assertSentTo($user, CreatedAccountByAdministrator::class);
        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('users_profiles', ['user_id' => $user->id]);
    }

    public function testGetUsersPaginated()
    {
        factory(User::class)->times(30)->create();

        $users = $this->r_users->getPaginatedUsers();
        $this->assertEquals(12, $users['meta']['pagination']['per_page']);
        $this->assertEquals(30, $users['meta']['pagination']['total']);
        $this->assertEquals(12, count($users['data']));
    }

    public function testGetUser()
    {
        $user = factory(User::class)->create();

        $repositoryUser = $this->r_users->getUser($user->id);
        $this->assertEquals((new UsersListTransformer)->transform($user), $repositoryUser['data']);
    }

    public function testIsUserDeletingHisAccount()
    {
        Event::fake();
        $administrator = $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        /*
         * Administrator delete user.
         */
        $isNotDeletinHisAccount = $this->r_users->isUserDeletingHisAccount($administrator, $user);
        Event::assertNotDispatched(UserTriedToDeleteHisOwnAccountEvent::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
        $this->assertFalse($isNotDeletinHisAccount);
        /*
         * Administrator delete his account.
         */
        $isDeletinHisAccount = $this->r_users->isUserDeletingHisAccount($administrator, $administrator);
        Event::assertDispatched(UserTriedToDeleteHisOwnAccountEvent::class, function ($event) use ($administrator) {
            return $event->user->id === $administrator->id;
        });
        $this->assertTrue($isDeletinHisAccount);
    }
}
