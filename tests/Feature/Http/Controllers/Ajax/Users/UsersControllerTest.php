<?php namespace Tests\Feature\Http\Controllers\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use obsession\Domain\Users\{
    Users\User,
};

class UsersControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testGetUserById()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users/users',
                [
                    'user_id' => $user->id,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertStatus(200);
    }

    public function testGetUserByIds()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users/users',
                [
                    'users_ids' => [$user->id, $user2->id],
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertStatus(200);
    }

    public function testGetUserByWord()
    {
        factory(User::class)->create();
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $this
            ->json(
                'GET',
                '/ajax/users/users',
                [
                    'term' => $user->full_name,
                ],
                [
                    "X-Requested-With" => "XMLHttpRequest",
                ]
            )
            ->assertStatus(200);
    }

    public function testToGetUsersWithoutAjaxRequest()
    {
        $this
            ->get('/ajax/users/users')
            ->assertStatus(405)
            ->assertSeeText(trans('errors.405_title'));
    }

    public function testChecksUserEmailAsEmailOwner()
    {
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
            ->assertStatus(200)
            ->assertJson(['data' => ['count' => 0]]);
    }

    public function testChecksUserEmailNotAsEmailOwner()
    {
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
            ->assertStatus(200)
            ->assertJson(['data' => ['count' => 1]]);
    }

    public function testToChecksUserEmailWithoutAjaxRequest()
    {
        $this
            ->get('/ajax/users/check-user-email')
            ->assertStatus(405)
            ->assertSeeText(trans('errors.405_title'));
    }
}
