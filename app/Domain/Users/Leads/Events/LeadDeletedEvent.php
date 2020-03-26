<?php

namespace template\Domain\Users\Leads\Events;

use template\Infrastructure\Contracts\Events\EventAbstract;
use template\Domain\Users\Leads\Lead;

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
