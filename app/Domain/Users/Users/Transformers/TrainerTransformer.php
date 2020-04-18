<?php

namespace template\Domain\Users\Users\Transformers;

use template\Domain\Users\Users\User;
use template\Infrastructure\Contracts\Transformers\TransformerAbstract;

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
            'friend_code' => $model->profile->formated_friend_code,
            'team_color' => $model->profile->team_color,
            'qr' => route('v1.users.qr', ['user' => $model->uniqid]),
        ];
    }
}
