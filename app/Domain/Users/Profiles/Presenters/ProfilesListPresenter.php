<?php

namespace obsession\Domain\Users\Profiles\Presenters;

use obsession\Infrastructure\Contracts\Presenters\PresenterAbstract;
use obsession\Domain\Users\Profiles\Transformers\ProfilesListTransformer;

class ProfilesListPresenter extends PresenterAbstract
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProfilesListTransformer();
    }
}
