<?php

namespace pkmnfriends\Domain\Users\Users\Transformers;

use pkmnfriends\Domain\Users\Users\User;
use pkmnfriends\Infrastructure\Contracts\Transformers\TransformerAbstract;

class TrainerChannelTransformer extends TransformerAbstract
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
            'channel' => $model->profile->twitch_channel,
        ];
    }
}
