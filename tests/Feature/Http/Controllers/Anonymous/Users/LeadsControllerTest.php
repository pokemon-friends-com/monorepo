<?php

namespace Tests\Feature\Http\Controllers\Anonymous\Users;

use template\Domain\Users\Leads\Events\LeadCreatedEvent;
use template\Domain\Users\Leads\Lead;
use template\Domain\Users\Leads\Notifications\HandshakeMailToConfirmReceptionToSender;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\OAuthTestCaseTrait;
use Tests\TestCase;

class LeadsControllerTest extends TestCase
{
    use OAuthTestCaseTrait;
    use DatabaseMigrations;

    public function testIndex()
    {
        $this
            ->get('/contact')
            ->assertSuccessful();
    }

    public function testStoreWithEmptyForm()
    {
        $lead = factory(Lead::class)->raw();
        Event::fake();
        Notification::fake();
        $this
            ->call('POST', '/contact', [
                'civility' => $lead['civility'],
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'subject' => '',
                'message' => '',
                'g-recaptcha-response' => '',
                'certify' => '',
            ], [], [], ['HTTP_REFERER' => '/contact'])
            ->assertStatus(302)
            ->assertRedirect('/contact');
        $this
            ->get('/contact')
            ->assertSuccessful()
            ->assertSee('The first name field is required.')
            ->assertSee('The last name field is required.')
            ->assertSee('The email field is required.')
            ->assertSee('The subject field is required.')
            ->assertSee('The message field is required.');
        Event::assertNotDispatched(LeadCreatedEvent::class);
        Notification::assertTimesSent(0, HandshakeMailToConfirmReceptionToSender::class);
        $this->assertDatabaseMissing('users_leads', $lead);
    }

    public function testStoreWithBadEmail()
    {
        $lead = factory(Lead::class)->raw();
        Event::fake();
        Notification::fake();
        $this
            ->call('POST', '/contact', [
                'civility' => $lead['civility'],
                'first_name' => $lead['first_name'],
                'last_name' => $lead['last_name'],
                'email' => $this->faker->text,
                'subject' => $this->faker->text,
                'message' => $this->faker->text,
                'g-recaptcha-response' => '',
                'certify' => true,
            ], [], [], ['HTTP_REFERER' => '/contact'])
            ->assertStatus(302)
            ->assertRedirect('/contact');
        $this
            ->get('/contact')
            ->assertSuccessful()
            ->assertSee('The email must be a valid email address.');
        Event::assertNotDispatched(LeadCreatedEvent::class);
        Notification::assertTimesSent(0, HandshakeMailToConfirmReceptionToSender::class);
        $this->assertDatabaseMissing('users_leads', $lead);
    }

    public function testStoreWithAnonymous()
    {
        $lead = factory(Lead::class)->raw();
        Event::fake();
        Notification::fake();
        $this
            ->post('/contact', [
                'civility' => $lead['civility'],
                'first_name' => $lead['first_name'],
                'last_name' => $lead['last_name'],
                'email' => $lead['email'],
                'subject' => $this->faker->text,
                'message' => $this->faker->text,
                'g-recaptcha-response' => '',
                'certify' => true,
            ])
            ->assertStatus(302)
            ->assertRedirect('/contact');
        Event::assertDispatched(LeadCreatedEvent::class);
        Notification::assertTimesSent(1, HandshakeMailToConfirmReceptionToSender::class);
        $this->assertDatabaseHas('users_leads', $lead);
    }

    public function testStoreWithAdministrator()
    {
        $user = $this->actingAsAdministrator();
        $lead = factory(Lead::class)->create([
            'user_id' => $user->id,
            'civility' => $user->civility,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
        Event::fake();
        Notification::fake();
        $this
            ->assertAuthenticated()
            ->post('/contact', [
                'civility' => $lead['civility'],
                'first_name' => $lead['first_name'],
                'last_name' => $lead['last_name'],
                'email' => $lead['email'],
                'subject' => $this->faker->text,
                'message' => $this->faker->text,
                'g-recaptcha-response' => '',
                'certify' => true,
            ])
            ->assertStatus(302)
            ->assertRedirect('/contact');
        Event::assertNotDispatched(LeadCreatedEvent::class);
        Notification::assertTimesSent(1, HandshakeMailToConfirmReceptionToSender::class);
    }

    public function testStoreWithCustomer()
    {
        $user = $this->actingAsCustomer();
        $lead = factory(Lead::class)->create([
            'user_id' => $user->id,
            'civility' => $user->civility,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
        Event::fake();
        Notification::fake();
        $this
            ->assertAuthenticated()
            ->post('/contact', [
                'civility' => $lead['civility'],
                'first_name' => $lead['first_name'],
                'last_name' => $lead['last_name'],
                'email' => $lead['email'],
                'subject' => $this->faker->text,
                'message' => $this->faker->text,
                'g-recaptcha-response' => '',
                'certify' => true,
            ])
            ->assertStatus(302)
            ->assertRedirect('/contact');
        Event::assertNotDispatched(LeadCreatedEvent::class);
        Notification::assertTimesSent(1, HandshakeMailToConfirmReceptionToSender::class);
    }
}
