<?php

namespace template\Http\Controllers\Anonymous\Files;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Files\Files\Repositories\FilesRepository;

class FilesController extends ControllerAbstract
{

    /**
     * @var FilesRepository|null
     */
    public $r_files = null;

    /**
     * MediasController constructor.
     *
     * @param FilesRepository $r_files
     */
    public function __construct(FilesRepository $r_files)
    {
        $this->r_files = $r_files;
    }

    /**
     * @param $path
     *
     * @return \Illuminate\Http\Response|void
     */
    public function document($path)
    {
        try {
            return $this->r_files->streamPublicDocument($path);
        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return abort(404);
    }

    /**
     * @param string $path
     *
     * @return mixed|void
     */
    public function thumbnail(string $path)
    {
        try {
            return $this->r_files->streamPublicThumbnail($path);
        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return abort(404);
    }
}
