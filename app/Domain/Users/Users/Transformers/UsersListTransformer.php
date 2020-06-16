<?php

namespace template\Domain\Users\Users\Transformers;

use template\Domain\Users\Profiles\Profile;
use template\Infrastructure\Contracts\Transformers\TransformerAbstract;
use template\Domain\Users\Users\User;

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
            'profile' => [],
            'locale' => [
                'language' => $model->locale,
                'timezone' => $model->timezone,
            ],
            'impersonation' => [
                'can_impersonate' => $model->canImpersonate(),
                'can_be_impersonated' => $model->canBeImpersonated(),
            ],
            'created_at' => $model
                ->created_at_tz
                ->format(trans('global.date_format')),
        ];

        if ($model->profile instanceof Profile) {
            $data['profile'] = [
                'friend_code' => $model->profile->friend_code,
                'team_color' => $model->profile->team_color,
                'family_situation' => [
                    'key' => $model->profile->family_situation,
                    'trans' => trans("profiles.family_situation.{$model->profile->family_situation}"),
                ],
                'maiden_name' => $model->profile->maiden_name,
                'birth_date' => is_null($model->profile->birth_date_carbon)
                    ? null
                    : $model
                        ->profile
                        ->birth_date_carbon
                        ->format(trans('global.date_format')),
            ];
        }

        return $data;
    }
}
