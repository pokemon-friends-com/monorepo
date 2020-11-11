<?php

namespace pkmnfriends\Domain\Users\Users\Transformers;

use Carbon\Carbon;
use pkmnfriends\Domain\Users\Users\User;
use pkmnfriends\Infrastructure\Contracts\Transformers\TransformerAbstract;

class TrainerTransformer extends TransformerAbstract
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
        return [
            'identifier' => $model->uniqid,
            'username' => $model->profile->username,
            'streamfeed_token' => $model->streamfeed_token,
            'friend_code' => [
                'default' => $model->profile->friend_code,
                'formated' => $model->profile->formated_friend_code,
            ],
            'birth_date' => $model->profile->birth_date_carbon,
            'team_color' => $model->profile->team_color,
            'qr' => route('v1.users.qr', ['user' => $model->uniqid]),
            'created_at' => new Carbon($model->created_at, $model->timezone),
        ];
    }
}
