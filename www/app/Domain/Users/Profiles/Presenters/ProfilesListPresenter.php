<?php

namespace pkmnfriends\Domain\Users\Profiles\Presenters;

use pkmnfriends\Infrastructure\Contracts\Presenters\PresenterAbstract;
use pkmnfriends\Domain\Users\Profiles\Transformers\ProfilesListTransformer;

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
