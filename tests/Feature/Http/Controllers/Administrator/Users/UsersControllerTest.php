<?php

namespace Tests\Feature\Http\Controllers\Administrator\Users;

use Illuminate\Support\Facades\Event;
use League\Csv\Reader;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\Domain\Users\Users\{
    Events\UserTriedToDeleteHisOwnAccountEvent,
    User,
};
use template\Domain\Users\Profiles\Profile;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testToVisitDashboardAsAnonymous()
    {
        $this
            ->get('/administrator/users/dashboard')
            ->assertRedirect('/login');
    }

    public function testToVisitDashboardAsCustomer()
    {
        $this->actingAsCustomer();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users/dashboard')
            ->assertStatus(403);
    }

    public function testToVisitDashboardAsAdministrator()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users/dashboard')
            ->assertSeeText('Dashboard')
            ->assertSuccessful();
    }

    public function testToVisitAnonymousDashboardAsAdministrator()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/')
            ->assertRedirect('/administrator/users/dashboard');
    }

    public function testToVisitIndex()
    {
        $administrator = $this->actingAsAdministrator();
        $users = factory(User::class)
            ->times(30)
            ->create()
            ->each(function (User $user) {
                factory(Profile::class)->create(['user_id' => $user->id]);
            });
        $this
            ->assertAuthenticated()
            ->get('/administrator/users')
            ->assertSuccessful()
            ->assertSeeText($administrator->email)
            ->assertSeeText($users->first()->email)
            ->assertDontSeeText($users->last()->email);
    }

    public function testToCreate()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users/create')
            ->assertSuccessful();
    }

    public function testToShow()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->get("/administrator/users/{$user->uniqid}")
            ->assertSuccessful();
    }

    public function testToEdit()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        factory(Profile::class)->create(['user_id' => $user->id]);
        $this
            ->assertAuthenticated()
            ->get("/administrator/users/{$user->uniqid}/edit")
            ->assertSuccessful();
    }

    public function testToDestroy()
    {
        $this->actingAsAdministrator();
        $user = factory(User::class)->create();
        $this
            ->assertAuthenticated()
            ->delete("/administrator/users/{$user->uniqid}")
            ->assertRedirect('/administrator/users');
        $this->assertSoftDeleted('users', ['uniqid' => $user->uniqid]);
    }

    public function testToDestroyWhenDeletingOwnAccount()
    {
        $user = $this->actingAsAdministrator();
        Event::fake();
        $this
            ->assertAuthenticated()
            ->delete("/administrator/users/{$user->uniqid}")
            ->assertRedirect('/administrator/users');
        Event::assertDispatched(UserTriedToDeleteHisOwnAccountEvent::class);
        $this->assertDatabaseHas('users', ['deleted_at' => null, 'uniqid' => $user->uniqid]);
    }

    public function testToExport()
    {
        $this->actingAsAdministrator();
        factory(User::class)
            ->times(30)
            ->create()
            ->each(function (User $user) {
                factory(Profile::class)->create(['user_id' => $user->id]);
            });
        $response = $this->get('/administrator/users/export');
        $response->assertHeader('Content-Disposition');

        $reader = Reader::createFromString($response->streamedContent());
        $reader->setDelimiter(';');
        $reader->setHeaderOffset(0);

        $this->assertCount(User::all()->count(), $reader);

        foreach ($reader->getRecords() as $record) {
            $this->assertEquals(array_keys($record), [
                trans('global.id'),
                trans('users.civility'),
                trans('users.last_name'),
                trans('users.first_name'),
                trans('users.profiles.family_situation'),
                trans('users.profiles.maiden_name'),
                trans('users.profiles.birth_date'),
                trans('users.email'),
                trans('users.role'),
                trans('users.locale'),
                trans('users.timezone'),
            ]);

            $index = User::all()->search(function ($user) use ($record) {
                return $user->uniqid === $record[trans('global.id')];
            });

            $this->assertNotFalse($index);
            $this->assertEquals(
                User::all()->get($index)->uniqid,
                $record[trans('global.id')]
            );
            User::all()->forget($index);
        }
    }
}
