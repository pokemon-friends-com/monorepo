<?php

namespace Tests\Feature\Http\Controllers\Administrator\Users;

use template\Domain\Users\Profiles\Profile;
use template\Domain\Users\Users\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfilesControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testEdit()
    {
        $user = $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get("/administrator/users/profiles/{$user->uniqid}/edit")
            ->assertSuccessful();
    }

    public function testUpdate()
    {
        $user = $this->actingAsAdministrator();
        $this
            ->from("/administrator/users/profiles/{$user->uniqid}/edit")
            ->assertAuthenticated()
            ->put("/administrator/users/profiles/{$user->uniqid}", [
                'birth_date' => $this->faker->date($this->dateFormat()),
                'family_situation' => $this->faker->randomElements(Profile::FAMILY_SITUATIONS),
                'maiden_name' => $this->faker->name,
                'timezone' => $this->faker->randomElements(timezones()),
                'locale' => $this->faker->randomElements(User::LOCALES),
            ])
            ->assertStatus(302)
            ->assertRedirect("/administrator/users/profiles/{$user->uniqid}/edit");
    }
}
