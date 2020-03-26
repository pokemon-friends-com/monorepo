<?php

namespace template\Domain\Users\Users\Transformers;

use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Transformers\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
            'family_situation' => [
                'key' => $model->profile->family_situation,
                'trans' => trans('profiles.family_situation.' . $model->profile->family_situation),
            ],
            'maiden_name' => $model->profile->maiden_name,
            'birth_date' => is_null($model->profile->birth_date_carbon)
                ? null
                : $model
                    ->profile
                    ->birth_date_carbon
                    ->format(trans('global.date_format')),
            'locale' => [
                'language' => $model->locale,
                'timezone' => $model->timezone,
            ],
            'is_sidebar_pined' => $model->profile->is_sidebar_pined,
        ];

        return $data;
    }
}
