<?php

namespace obsession\Domain\Users\Users\Presenters;

use obsession\Infrastructure\Contracts\Presenters\PresenterAbstract;
use obsession\Domain\Users\Users\Transformers\UsersListTransformer;

class UsersListPresenter extends PresenterAbstract
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UsersListTransformer();
    }
}
