<?php

namespace template\Domain\Users\Leads\Presenters;

use template\Infrastructure\Contracts\Presenters\PresenterAbstract;
use template\Domain\Users\Leads\Transformers\LeadsListTransformer;

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
