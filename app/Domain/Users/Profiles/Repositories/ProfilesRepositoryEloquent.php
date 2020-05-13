<?php

namespace template\Domain\Users\Profiles\Repositories;

use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Collection;
use template\Infrastructure\Contracts\{
    Request\RequestAbstract,
    Repositories\RepositoryEloquentAbstract
};
use template\Domain\Users\Users\{
    User,
    Repositories\UsersRepositoryEloquent
};
use template\Domain\Users\Profiles\{
    Criterias\NotAuthenticatedLimitCriteria,
    Criterias\OrderByUpdateAtCriteria,
    Criterias\WhereFriendCodeNotNullCriteria,
    Criterias\WhereSponsoredCriteria,
    Criterias\WhereFriendCodeIsCriteria,
    Profile,
    Events\ProfileUpdatedEvent,
    Presenters\ProfilesListPresenter
};

class ProfilesRepositoryEloquent extends RepositoryEloquentAbstract implements ProfilesRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user.gid' => 'like',
        'friend_code' => 'like',
        'team_color'
    ];

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * ProfilesRepositoryEloquent constructor.
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
     *
     */
    public function boot()
    {
        $this
            ->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'))
            ->pushCriteria(WhereFriendCodeNotNullCriteria::class)
            ->pushCriteria(OrderByUpdateAtCriteria::class);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Profile::class;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes): Profile
    {
        return parent::create($attributes);
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id): Profile
    {
        $profile = parent::update($attributes, $id);

        event(new ProfileUpdatedEvent($profile));

        return $profile;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id): int
    {
        $profile = parent::delete($id);

        return $profile;
    }

    /**
     * {@inheritdoc}
     */
    public function getFamilySituations(): Collection
    {
        return collect(Profile::FAMILY_SITUATIONS);
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createUserProfile(
        User $user,
        $parameters = []
    ): User {
        $this->create(array_merge(['user_id' => $user->id], $parameters));

        return $user;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateUserProfile(
        User $user,
        $parameters = []
    ): User {
        $this->update($parameters, $user->profile->id);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteUserProfile(User $user): ProfilesRepository
    {
        $user->profile->delete();

        return $this;
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
    public function getLocales(): Collection
    {
        return $this->r_users->getLocales();
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezones(): Collection
    {
        return $this->r_users->getTimezones();
    }

    /**
     * @return Collection
     */
    public function getTeamsColors(): Collection
    {
        return new Collection(Profile::COLORS);
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getUserProfile(User $user): array
    {
        return $this
            ->setPresenter(new ProfilesListPresenter())
            ->find($user->profile->id);
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function filterByFriendCode(?string $friend_code): ProfilesRepository
    {
        if (!is_null($friend_code) && !empty($friend_code)) {
            $this->pushCriteria(new WhereFriendCodeIsCriteria($friend_code));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateUserProfileWithRequest(
        RequestAbstract $request,
        User $user
    ): void {
        $data = [
            'birth_date' => $request->has('birth_date')
                ? Carbon::createFromFormat(
                    trans('global.date_format'),
                    $request->get('birth_date')
                )->format('Y-m-d')
                : null,
            'nickname' => $request->get('nickname'),
            'family_situation' => $request->get('family_situation'),
            'maiden_name' => $request->get('maiden_name'),
            'friend_code' => $request->get('friend_code'),
            'team_color' => $request->get('team_color'),
            'is_sidebar_pined' => $request->get('is_sidebar_pined'),
        ];
        $data = array_filter(
            $data,
            function ($v) {
                return !is_null($v);
            }
        );

        if ($data) {
            $this->update($data, $user->profile->id);
        }

        $data = [
            'timezone' => $request->get('timezone'),
            'locale' => $request->get('locale'),
            'civility' => $request->get('civility'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
        ];
        $data = array_filter(
            $data,
            function ($v) {
                return !is_null($v);
            }
        );

        if ($data) {
            $user = $this->r_users->update($data, $user->id);
            $this->r_users->refreshSession($user);
        }
    }
}
