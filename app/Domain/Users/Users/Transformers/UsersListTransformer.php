<?php namespace template\Domain\Users\Users\Transformers;

use template\Infrastructure\Contracts\Transformers\TransformerAbstract;
use template\Domain\Users\Users\User;
use template\Domain\Users\Leads\Lead;

class UsersListTransformer extends TransformerAbstract
{

    /**
     * Transform the User entity
     *
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        $data = [
            'id' => $model->id,
            'identifier' => $model->uniqid,
            'full_name' => $model->full_name,
            'civility_name' => $model->civility_name,
            'civility' => [
                'key' => $model->civility,
                'trans' => trans('users.civility.' . $model->civility),
            ],
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'email' => $model->email,
            'role' => [
                'key' => $model->role,
                'trans' => trans('users.role.' . $model->role),
            ],
            'lead' => [
                'is_lead' => false,
                'id' => 0,
            ],
            'locale' => [
                'language' => $model->locale,
                'timezone' => $model->timezone,
            ],
            'impersonation' => [
                'can_impersonate' => $model->canImpersonate(),
                'can_be_impersonated' => $model->canBeImpersonated(),
            ],
        ];

        if ($model->lead instanceof Lead) {
            $data['lead'] = [
                'is_lead' => true,
                'id' => $model->lead->id,
            ];
        }

        return $data;
    }
}
