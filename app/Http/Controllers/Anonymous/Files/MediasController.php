<?php

namespace template\Http\Controllers\Anonymous\Files;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Files\Medias\Repositories\MediasRepositoryEloquent;

class MediasController extends ControllerAbstract
{

    /**
     * @var MediasRepositoryEloquent|null
     */
    public $r_medias = null;

    /**
     * MediasController constructor.
     *
     * @param MediasRepositoryEloquent $r_medias
     */
    public function __construct(MediasRepositoryEloquent $r_medias)
    {
        $this->r_medias = $r_medias;
    }

    /**
     * @param $hash
     *
     * @return mixed
     */
    public function media($hash)
    {
        try {
            return $this
                ->r_medias
                ->streamPrivateDocument($hash);
        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return abort(404);
    }
}
