<?php namespace Tests\Feature\Http\Controllers\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use obsession\Domain\Users\Users\User;

class UsersControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testGetUserById()
    {
        $this->actingAsAdministrator();
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users',
                [
                    'user_id' => $user->id,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertSuccessful();
    }

    public function testGetUserByIds()
    {
        $this->actingAsAdministrator();
        factory(User::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users',
                [
                    'users_ids' => [$user->id, $user2->id],
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertSuccessful();
    }

    public function testGetUserByWord()
    {
        $this->actingAsAdministrator();
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users',
                [
                    'term' => $user->full_name,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertSuccessful();
    }

    public function testToGetUsersAsAnonymous()
    {
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users',
                [
                    'user_id' => $user->id,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertStatus(403);
    }

    public function testToGetUsersWithoutAjaxRequest()
    {
        $this
            ->get('/ajax/users')
            ->assertStatus(405)
            ->assertSeeText(trans('errors.405_title'));
    }

    public function testChecksUserEmailAsEmailOwner()
    {
        $this->actingAsAdministrator();
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users/check-user-email',
                [
                    'email' => $user->email,
                    'not_user_id' => $user->uniqid,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertSuccessful()
            ->assertJson(['data' => ['count' => 0]]);
    }

    public function testChecksUserEmailNotAsEmailOwner()
    {
        $this->actingAsAdministrator();
        factory(User::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users/check-user-email',
                [
                    'email' => $user->email,
                    'not_user_id' => $user2->uniqid,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertSuccessful()
            ->assertJson(['data' => ['count' => 1]]);
    }

    public function testToChecksUserEmailAsAnonymous()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users/check-user-email',
                [
                    'email' => $user->email,
                    'not_user_id' => $user2->uniqid,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertStatus(403);
    }

    public function testToChecksUserEmailWithoutAjaxRequest()
    {
        $this
            ->get('/ajax/users/check-user-email')
            ->assertStatus(405)
            ->assertSeeText(trans('errors.405_title'));
    }
}
