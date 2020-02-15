<?php

namespace template\Domain\Users\Leads\Repositories;

use Illuminate\Support\Collection;
use template\Domain\Users\Leads\Lead;
use template\Domain\Users\Users\User;
use template\Infrastructure\Interfaces\Repositories\RepositoryInterface;

interface LeadsRepositoryInterface extends RepositoryInterface
{

    /**
     * Create Lead request and fire event "LeadCreatedEvent".
     *
     * @param array $attributes
     *
     * @event template\Domain\Users\Leads\Events\LeadCreatedEvent
     * @return \template\Domain\Users\Leads\Lead
     */
    public function create(array $attributes): Lead;

    /**
     * Update Lead request and fire event "LeadUpdatedEvent".
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event template\Domain\Users\Leads\Events\LeadUpdatedEvent
     * @return \template\Domain\Users\Leads\Lead
     */
    public function update(array $attributes, $id): Lead;

    /**
     * Delete Lead request and fire event "LeadDeletedEvent".
     *
     * @param integer $id
     *
     * @event template\Domain\Users\Leads\Events\LeadDeletedEvent
     * @return \template\Domain\Users\Leads\Lead
     */
    public function delete($id): Lead;

    /**
     * @return Collection
     */
    public function getCivilities(): Collection;

    /**
     * Get the list of all leads, active and soft deleted users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allWithTrashed(): Collection;

    /**
     * Get only leads that was soft deleted.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function onlyTrashed(): Collection;

    /**
     * Filter leads by name.
     *
     * @param string $name The lead last name and/or lead first name
     */
    public function filterByName($name): self;

    /**
     * Filter leads by emails.
     *
     * @param string $email The lead email
     */
    public function filterByEmail($email): self;

    /**
     * Qualify the lead as :
     * - new lead and create it
     * - existing lead and return the previously created one
     * - connected user and return the current user
     *
     * @param $civility
     * @param $first_name
     * @param $last_name
     * @param $email
     *
     * @return Lead
     */
    public function qualifyLead($civility, $first_name, $last_name, $email): Lead;

    /**
     * @return array
     */
    public function getLeadsPaginated(): array;

    /**
     * @param Lead $lead
     * @return User
     */
    public function createUserFromLead(Lead $lead): User;
}
