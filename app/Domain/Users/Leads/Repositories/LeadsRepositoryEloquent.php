<?php namespace template\Domain\Users\Leads\Repositories;

use Illuminate\Container\Container as Application;
use template\Infrastructure\Contracts\{
    Repositories\RepositoryEloquentAbstract,
    Request\RequestAbstract
};
use template\Domain\Users\{
    Users\User,
    Users\Repositories\UsersRepositoryEloquent
};
use template\Domain\Users\Leads\{
    Repositories\LeadsRepositoryInterface,
    Lead,
    Criterias\EmailLikeCriteria,
    Criterias\FullNameLikeCriteria,
    Events\LeadCreatedEvent,
    Events\LeadUpdatedEvent,
    Events\LeadDeletedEvent,
    Presenters\LeadsListPresenter
};

class LeadsRepositoryEloquent extends RepositoryEloquentAbstract implements LeadsRepositoryInterface
{

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * LeadsRepositoryEloquent constructor.
     *
     * @param Application $app
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(
        Application $app,
        UsersRepositoryEloquent $r_users
    ) {
        parent::__construct($app);

        $this->r_users = $r_users;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Lead::class;
    }

    /**
     * Create Lead request and fire event "LeadCreatedEvent".
     *
     * @param array $attributes
     *
     * @event template\Domain\Users\Leads\Events\LeadCreatedEvent
     * @return \template\Domain\Users\Leads\Lead
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes): Lead
    {
        $lead = parent::create($attributes);

        event(new LeadCreatedEvent($lead));

        return $lead;
    }

    /**
     * Update Lead request and fire event "LeadUpdatedEvent".
     *
     * @param array $attributes
     * @param integer $id
     *
     * @event template\Domain\Users\Leads\Events\LeadUpdatedEvent
     * @return \template\Domain\Users\Leads\Lead
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): Lead
    {
        $lead = parent::update($attributes, $id);

        event(new LeadUpdatedEvent($lead));

        return $lead;
    }

    /**
     * Delete Lead request and fire event "LeadDeletedEvent".
     *
     * @param integer $id
     *
     * @event template\Domain\Users\Leads\Events\LeadDeletedEvent
     * @return \template\Domain\Users\Leads\Lead
     */
    public function delete($id): Lead
    {
        $lead = $this->find($id);

        parent::delete($lead->id);

        event(new LeadDeletedEvent($lead));

        return $lead;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCivilities()
    {
        return $this->r_users->getCivilities();
    }

    /**
     * Get the list of all leads, active and soft deleted users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allWithTrashed()
    {
        return Lead::withTrashed()->get();
    }

    /**
     * Get only leads that was soft deleted.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function onlyTrashed()
    {
        return Lead::onlyTrashed()->get();
    }

    /**
     * Filter leads by name.
     *
     * @param string $name The lead last name and/or lead first name
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByName($name)
    {
        if (!is_null($name) && !empty($name)) {
            $this->pushCriteria(new FullNameLikeCriteria($name));
        }

        return $this;
    }

    /**
     * Filter leads by emails.
     *
     * @param string $email The lead email
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByEmail($email)
    {
        if (!is_null($email) && !empty($email)) {
            $this->pushCriteria(new EmailLikeCriteria($email));
        }

        return $this;
    }

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
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function qualifyLead($civility, $first_name, $last_name, $email)
    {
        if (\Auth::check()) {
            return \Auth::user();
        }

        $lead = $this->findByField('email', $email);

        if (0 === $lead->count()) {
            return $this
                ->create([
                    'civility' => $civility,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                ]);
        }

        return $lead->first();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getLeadsPaginated()
    {
        return $this
            ->with(['user'])
            ->setPresenter(new LeadsListPresenter())
            ->orderBy('id', 'desc')
            ->paginate();
    }

    /**
     * @param Lead $lead
     * @return User
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createUserFromLead(Lead $lead): User
    {
        $user = $this
            ->r_users
            ->createUser(
                $lead->civility,
                $lead->first_name,
                $lead->last_name,
                $lead->email
            );

        $lead->user_id = $user->id;
        $lead->save();

        return $user;
    }
}
