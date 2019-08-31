<?php namespace obsession\Domain\Users\Leads\Transformers;

use obsession\Infrastructure\Contracts\Transformers\TransformerAbstract;
use obsession\Domain\Users\
{
    Users\User,
    Leads\Lead
};

class LeadsListTransformer extends TransformerAbstract
{

    /**
     * Transform the Lead entity
     *
     * @param Lead $model
     *
     * @return array
     */
    public function transform(Lead $model)
    {
        return [
            'id' => (int)$model->id,
            'identifier' => $model->identifier,
            'civility_name' => $model->civility_name,
            'email' => $model->email,
            'user' => [
                'is_user' => $model->user instanceof User,
                'id' => (int)$model->user_id,
            ],
        ];
    }
}
