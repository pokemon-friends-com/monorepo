<?php

namespace Tests\Feature\Http\Controllers\Administrator\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use template\Domain\Users\Users\{
    Notifications\CreatedAccountByAdministrator,
    User
};
use template\Domain\Users\{
    Profiles\Profile,
    Leads\Lead
};

class LeadsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $leads = factory(Lead::class)->times(30)->create();
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/administrator/users/leads')
            ->assertSeeText('Leads')
            ->assertSeeText('Transform into a user')
            ->assertSeeText($leads->last()->email)
            ->assertSeeText($leads->last()->civility_name)
            ->assertSeeText($leads->last()->identifier)
            ->assertDontSeeText($leads->first()->email)
            ->assertDontSeeText($leads->first()->civility_name)
            ->assertDontSeeText($leads->first()->identifier)
            ->assertSuccessful();
    }

    public function testUpdate()
    {
        $this->actingAsAdministrator();
        $lead = factory(Lead::class)->create();
        Notification::fake();
        $this
            ->assertAuthenticated()
            ->put("/administrator/users/leads/{$lead->id}")
            ->assertStatus(302)
            ->assertRedirect('administrator/users/leads');
        $lead->refresh();
        Notification::assertSentTo($lead->user, CreatedAccountByAdministrator::class);

        $this
            ->assertAuthenticated()
            ->get('/administrator/users/leads')
            ->assertSeeText('No action')
            ->assertSeeInOrder(['<tr id="lead_1">', '<i class="far fa-user-circle" title="Transformed user"></i>'])
            ->assertSeeText($lead->email)
            ->assertSeeText($lead->civility_name)
            ->assertSeeText($lead->identifier)
            ->assertSuccessful();
    }

    public function testUpdateWithApostrophe()
    {
        $this->actingAsAdministrator();
        $lead = factory(Lead::class)->create(['last_name' => "D'amore"]);
        Notification::fake();
        $this
            ->assertAuthenticated()
            ->put("/administrator/users/leads/{$lead->id}")
            ->assertRedirect('administrator/users/leads');
        $lead->refresh();
        Notification::assertSentTo($lead->user, CreatedAccountByAdministrator::class);

        $this
            ->assertAuthenticated()
            ->get('/administrator/users/leads')
            ->assertSeeText('No action')
            ->assertSeeInOrder(['<tr id="lead_1">', '<i class="far fa-user-circle" title="Transformed user"></i>'])
            ->assertSeeText($lead->email)
            ->assertSeeText($lead->civility_name)
            ->assertSeeText($lead->identifier)
            ->assertSuccessful();
    }
}
