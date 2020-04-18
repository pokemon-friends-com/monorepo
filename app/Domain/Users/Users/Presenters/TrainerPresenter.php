<?php

namespace template\Domain\Users\Users\Presenters;

use template\Infrastructure\Contracts\Presenters\PresenterAbstract;
use template\Domain\Users\Users\Transformers\TrainerTransformer;

class TrainerPresenter extends PresenterAbstract
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TrainerTransformer();
    }
}
