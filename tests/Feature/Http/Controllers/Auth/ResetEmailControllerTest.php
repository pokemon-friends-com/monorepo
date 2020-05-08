<?php

namespace Tests\Feature\Http\Controllers\Auth;

use template\Domain\Users\Users\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Yaquawa\Laravel\EmailReset\EmailResetBrokerFactory;

class ResetEmailControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testToVisitEmailReset()
    {
        $user = $this->actingAsCustomer();
        $newEmail = $this->faker->email;
        $this->setUserNewEmail($user, $newEmail);
        $token = EmailResetBrokerFactory::broker()->createToken($user);
        $this->assertDatabaseHas('email_resets', [
            'new_email' => $user->newEmail,
        ]);
        $this
            ->get("/email/reset/{$token}")
            ->assertRedirect();
        $this->assertDatabaseMissing('email_resets', [
            'new_email' => $user->newEmail,
        ]);
    }

//    public function testToVisitEmailResetWithBadToken()
//    {
//        $token = $this->faker->uuid;
//        $this->actingAsCustomer();
//        $this
//            ->get("/email/reset/{$token}")
//            ->assertNotFound();
//    }

//    public function testToVisitEmailResetWhenUserIsNotLoggedIn()
//    {
//        $user = factory(User::class)->create();
//        $newEmail = $this->faker->email;
//        $this->setUserNewEmail($user, $newEmail);
//        $token = EmailResetBrokerFactory::broker()->createToken($user);
//        $this->assertDatabaseHas('email_resets', [
//            'new_email' => $newEmail,
//        ]);
//        $this
//            ->get("/email/reset/{$token}")
//            ->assertRedirect('/login');
//        $this->assertDatabaseHas('email_resets', [
//            'new_email' => $newEmail,
//        ]);
//    }

    /**
     * @param string $newEmail
     *
     * @throws \ReflectionException
     */
    protected function setUserNewEmail(User $user, string $newEmail): void
    {
        $reflector = new \ReflectionClass($user);
        $reflectorProperty = $reflector->getProperty('newEmail');
        $reflectorProperty->setAccessible(true);
        $reflectorProperty->setValue($user, $newEmail);
    }
}
