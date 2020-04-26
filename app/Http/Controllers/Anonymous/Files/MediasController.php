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
        $media = null;

        try {
            $media = $this->r_medias->streamPrivateDocument($hash);
        } catch (\Exception $exception) {
            abort(404);
        }

        return $media;
    }
}
