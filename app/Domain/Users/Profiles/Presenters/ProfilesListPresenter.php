<?php

namespace template\Domain\Users\Profiles\Presenters;

use template\Infrastructure\Contracts\Presenters\PresenterAbstract;
use template\Domain\Users\Profiles\Transformers\ProfilesListTransformer;

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
