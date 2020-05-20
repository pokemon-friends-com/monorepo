<?php

namespace template\Http\Controllers\Anonymous\Files;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Files\Medias\Repositories\MediasRepositoryEloquent;

class MediasController extends ControllerAbstract
{

    /**
     * @var MediasRepositoryEloquent|null
     */
    public $rMedias = null;

    /**
     * MediasController constructor.
     *
     * @param MediasRepositoryEloquent $rMedias
     */
    public function __construct(MediasRepositoryEloquent $rMedias)
    {
        $this->rMedias = $rMedias;
    }

    /**
     * @param $hash
     *
     * @return mixed
     */
    public function media($hash)
    {
        $media = null;

        try {
            $media = $this->rMedias->streamPrivateDocument($hash);
        } catch (\Exception $exception) {
            abort(404);
        }

        return $media;
    }
}
