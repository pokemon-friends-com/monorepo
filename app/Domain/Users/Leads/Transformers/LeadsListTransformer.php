<?php namespace template\Domain\Users\Leads\Transformers;

use template\Infrastructure\Contracts\Transformers\TransformerAbstract;
use template\Domain\Users\
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
        $lead = [
            'id' => (int)$model->id,
            'identifier' => $model->identifier,
            'civility_name' => $model->civility_name,
            'email' => $model->email,
            'user' => [
                'is_user' => (bool)$model->user_id,
            ],
        ];

        if ($lead['user']['is_user']) {
            $lead['user']['identifier'] = $model->user->uniqid;
        }

        return $lead;
    }
}
