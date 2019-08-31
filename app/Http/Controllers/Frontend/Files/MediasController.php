<?php namespace obsession\Http\Controllers\Frontend\Files;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Domain\Files\Medias\Repositories\MediasRepositoryEloquent;

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

        $this->before();
    }

    /**
     * @param $path
     *
     * @return \Illuminate\Http\Response
     */
    public function document($path)
    {
        try {
            return $this
                ->r_medias
                ->streamPublicDocument($path);
        }
        catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return abort(404);
    }

    /**
     *
     */
    public function thumbnail($path)
    {
        // Direct output, don't need return statement.
        $this
            ->r_medias
            ->outputPublicThumbnails($path);
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
        }
        catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return abort(404);
    }
}
