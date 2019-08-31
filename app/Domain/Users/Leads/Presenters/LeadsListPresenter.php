<?php namespace obsession\Domain\Users\Leads\Presenters;

use obsession\Infrastructure\Contracts\Presenters\PresenterAbstract;
use obsession\Domain\Users\Leads\Transformers\LeadsListTransformer;

class LeadsListPresenter extends PresenterAbstract
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LeadsListTransformer();
    }
}
