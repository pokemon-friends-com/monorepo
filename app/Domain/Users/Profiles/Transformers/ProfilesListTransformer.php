<?php namespace obsession\Domain\Users\Profiles\Transformers;

use obsession\Infrastructure\Contracts\Transformers\TransformerAbstract;
use obsession\Domain\Users\Profiles\Profile;

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
            'id' => (int)$model->id,
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
        ];

        return $data;
    }
}
