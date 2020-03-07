<?php

namespace template\Domain\Users\Profiles\Transformers;

use template\Infrastructure\Contracts\Transformers\TransformerAbstract;
use template\Domain\Users\Profiles\Profile;

class ProfilesListTransformer extends TransformerAbstract
{

    /**
     * Transform the Profile entity
     *
     * @param Profile $model
     *
     * @return array
     */
    public function transform(Profile $model)
    {
        $data = [
            'friend_code' => $model->friend_code,
            'team_color' => $model->team_color,
            'family_situation' => [
                'key' => $model->family_situation,
                'trans' => trans('profiles.family_situation.' . $model->family_situation),
            ],
            'maiden_name' => $model->maiden_name,
            'birth_date' => is_null($model->birth_date_carbon)
                ? null
                : $model
                    ->birth_date_carbon
                    ->format(trans('global.date_format')),
            'locale' => [
                'language' => $model->user->locale,
                'timezone' => $model->user->timezone,
            ],
            'user' => [
                'identifier' => $model->user->uniqid,
                'first_name' => $model->user->first_name,
                'last_name' => $model->user->last_name,
                'civility' => $model->user->civility,
            ],
        ];

        return $data;
    }
}
