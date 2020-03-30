<?php

namespace Tests\Unit\Domain\Users\Leads\Repositories;

use template\Domain\Users\Leads\Events\LeadCreatedEvent;
use template\Domain\Users\Leads\Events\LeadDeletedEvent;
use template\Domain\Users\Leads\Events\LeadUpdatedEvent;
use template\Domain\Users\Leads\Lead;
use template\Domain\Users\Users\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use template\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;

class LeadsRepositoryEloquentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var LeadsRepositoryEloquent|null
     */
    protected $r_leads = null;

    public function __construct()
    {
        parent::__construct();

        $this->r_leads = app()->make(LeadsRepositoryEloquent::class);
    }

    public function testCheckIfRepositoryIsCorrectlyInstantiated()
    {
        $this->assertTrue($this->r_leads instanceof LeadsRepositoryEloquent);
    }

    public function testModel()
    {
        $this->assertEquals(Lead::class, $this->r_leads->model());
    }

    public function testCreate()
    {
        $rawUser = factory(Lead::class)->raw();
        Event::fake();
        $lead = $this->r_leads->create($rawUser);
        Event::assertDispatched(LeadCreatedEvent::class, function ($event) use ($lead) {
            return $event->lead->id === $lead->id;
        });
        $this->assertDatabaseHas('users_leads', $lead->toArray());
    }

    public function testUpdate()
    {
        $lead = factory(Lead::class)->create();
        $rawUser = factory(Lead::class)->raw();
        Event::fake();
        $lead = $this->r_leads->update($rawUser, $lead->id);
        Event::assertDispatched(LeadUpdatedEvent::class, function ($event) use ($lead) {
            return $event->lead->id === $lead->id;
        });
        $this->assertDatabaseHas('users_leads', $lead->toArray());
    }

    public function testDelete()
    {
        $lead = factory(Lead::class)->create();
        Event::fake();
        $lead = $this->r_leads->delete($lead->id);
        Event::assertDispatched(LeadDeletedEvent::class, function ($event) use ($lead) {
            return $event->lead->id === $lead->id;
        });
        $this->assertDatabaseMissing('users_leads', $lead->toArray());

        // @todo xABE : Lead have to be soft deletable
//        $this->assertDatabaseHas('users_leads', $lead->toArray());
//        $this->assertSoftDeleted('users_leads', $lead->toArray());
    }

    public function testGetCivilities()
    {
        $this->assertEquals(User::CIVILITIES, $this->r_leads->getCivilities()->toArray());
    }

    public function testAllWithTrashed()
    {
        $this->markTestSkipped('@todo xABE : Lead have to be soft deletable');

        factory(Lead::class)->create();
        factory(Lead::class)->create();
        factory(Lead::class)->states('deleted')->create();
        $this->assertEquals(3, $this->r_leads->allWithTrashed()->count());
    }

    public function testOnlyTrashed()
    {
        $this->markTestSkipped('@todo xABE : Lead have to be soft deletable');

        factory(Lead::class)->create();
        factory(Lead::class)->create();
        factory(Lead::class)->states('deleted')->create();
        $this->assertEquals(1, $this->r_leads->onlyTrashed()->count());
    }

    public function testFilterByName()
    {
        factory(Lead::class)->create();
        $lead = factory(Lead::class)->create();
        // @todo xABE : Lead have to be soft deletable
//        factory(Lead::class)->states('deleted')->create();
        $repositoryLead = $this
            ->r_leads
            ->skipPresenter()
            ->filterByName($lead->first_name)
            ->get();
        $this->assertEquals(1, $repositoryLead->count());
        $this->assertEquals($lead->full_name, $repositoryLead->first()->full_name);
    }

    public function testFilterByEmail()
    {
        factory(Lead::class)->create();
        $lead = factory(Lead::class)->create();
        // @todo xABE : Lead have to be soft deletable
//        factory(Lead::class)->states('deleted')->create();
        $repositoryLead = $this
            ->r_leads
            ->skipPresenter()
            ->filterByEmail($lead->email)
            ->get();
        $this->assertEquals(1, $repositoryLead->count());
        $this->assertEquals($lead->email, $repositoryLead->first()->email);
    }

    public function testQualifyLead()
    {
        /*
         * new Lead.
         */
        $lead = factory(Lead::class)->raw();
        $repositoryLead = $this
            ->r_leads
            ->qualifyLead($lead['civility'], $lead['first_name'], $lead['last_name'], $lead['email']);
        $this->assertEquals($lead['email'], $repositoryLead->email);
        /*
         * Existing Lead.
         */
        factory(Lead::class)->create();
        $lead = factory(Lead::class)->create();
        // @todo xABE : Lead have to be soft deletable
//        factory(Lead::class)->states('deleted')->create();
        $repositoryLead = $this
            ->r_leads
            ->qualifyLead($lead->civility, $lead->first_name, $lead->last_name, $lead->email);
        $this->assertEquals($lead->id, $repositoryLead->id);
    }

    public function testGetLeadsPaginated()
    {
        factory(Lead::class)->times(30)->create();
        $leads = $this->r_leads->getLeadsPaginated();
        $this->assertEquals(12, $leads['meta']['pagination']['per_page']);
        $this->assertEquals(30, $leads['meta']['pagination']['total']);
        $this->assertEquals(12, count($leads['data']));
    }

    public function testCreateUserFromLead()
    {
        factory(Lead::class)->create();
        $lead = factory(Lead::class)->create();
        // @todo xABE : Lead have to be soft deletable
//        factory(Lead::class)->states('deleted')->create();
        $user = $this->r_leads->createUserFromLead($lead);
        $this->assertEquals($lead->email, $user->email);
    }
}
