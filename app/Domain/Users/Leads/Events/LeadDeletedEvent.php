<?php namespace obsession\Domain\Users\Leads\Events;

use obsession\Infractucture\Contracts\Events\EventAbstract;
use obsession\Domain\Users\Leads\Lead;

class LeadDeletedEvent extends EventAbstract
{

    /**
     * @var Lead|null
     */
    public $lead = null;

    /**
     * LeadUpdatedEvent constructor.
     *
     * @param Lead $lead
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }
}
