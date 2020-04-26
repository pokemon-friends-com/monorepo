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
     * @return \Illuminate\Http\Response
     */
    public function document($path)
    {
        $document = null;

        try {
            $document = $this->r_files->streamPublicDocument($path);
        } catch (\Exception $exception) {
            abort(404);
        }

        return $document;
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function thumbnail(string $path)
    {
        $thumbnail = null;

        try {
            $thumbnail = $this->r_files->streamPublicThumbnail($path);
        } catch (\Exception $exception) {
            abort(404);
        }

        return $thumbnail;
    }
}
