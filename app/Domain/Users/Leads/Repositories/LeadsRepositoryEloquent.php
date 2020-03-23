<?php

namespace template\Domain\Users\Leads\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Support\Collection;
use template\Infrastructure\Contracts\{
    Repositories\RepositoryEloquentAbstract,
    Request\RequestAbstract
};
use template\Domain\Users\{
    Users\User,
    Users\Repositories\UsersRepositoryEloquent
};
use template\Domain\Users\Leads\{Repositories\LeadsRepositoryInterface,
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
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes): Lead
    {
        $lead = parent::create($attributes);

        event(new LeadCreatedEvent($lead));

        return $lead;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): Lead
    {
        $lead = parent::update($attributes, $id);

        event(new LeadUpdatedEvent($lead));

        return $lead;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id): Lead
    {
        $lead = $this->find($id);

        parent::delete($lead->id);

        event(new LeadDeletedEvent($lead));

        return $lead;
    }

    /**
     * {@inheritdoc}
     */
    public function getCivilities(): Collection
    {
        return $this->r_users->getCivilities();
    }

    /**
     * {@inheritdoc}
     */
    public function allWithTrashed(): Collection
    {
        return Lead::withTrashed()->get();
    }

    /**
     * {@inheritdoc}
     */
    public function onlyTrashed(): Collection
    {
        return Lead::onlyTrashed()->get();
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByName($name): LeadsRepositoryInterface
    {
        if (!is_null($name) && !empty($name)) {
            $this->pushCriteria(new FullNameLikeCriteria($name));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByEmail($email): LeadsRepositoryInterface
    {
        if (!is_null($email) && !empty($email)) {
            $this->pushCriteria(new EmailLikeCriteria($email));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function qualifyLead($civility, $first_name, $last_name, $email): Lead
    {
        $lead = $this
            ->with('user')
            ->findByField('email', $email);

        if (0 === $lead->count()) {
            $lead = $this
                ->create([
                    'civility' => $civility,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                ]);
        } else {
            $lead = $lead->first();
        }

        if (!$lead->user) {
            $user = $this->r_users->findByField('email', $email, ['id']);

            if ($user->first()) {
                $lead->user_id = $user->first()->id;
                $lead->save();
            }
        }

        return $lead;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getLeadsPaginated(): array
    {
        return $this
            ->with(['user'])
            ->setPresenter(new LeadsListPresenter())
            ->orderBy('id', 'desc')
            ->paginate();
    }

    /**
     * {@inheritdoc}
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
