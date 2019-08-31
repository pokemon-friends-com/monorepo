<?php namespace Tests\Feature\Http\Controllers\Backend\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use obsession\Domain\Users\{
    Users\Notifications\CreatedAccountByAdministrator,
    Users\User,
    Profiles\Profile,
    Leads\Lead
};

class LeadsControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testIndex()
    {
        $this->actingAsAdministrator();
        $this
            ->assertAuthenticated()
            ->get('/backend/leads')
            ->assertStatus(200);
    }

    public function testUpdate()
    {
        $this->actingAsAdministrator();
        $lead = factory(Lead::class)->create();
        Notification::fake();
        $this
            ->assertAuthenticated()
            ->put('/backend/leads/'.$lead->id)
            ->assertStatus(302)
            ->assertRedirect('backend/leads');
        $lead->refresh();
        Notification::assertSentTo($lead->user, CreatedAccountByAdministrator::class);
    }
}
