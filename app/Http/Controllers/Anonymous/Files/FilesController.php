<?php

namespace pkmnfriends\Http\Controllers\Anonymous\Files;

use pkmnfriends\Infrastructure\Contracts\Controllers\ControllerAbstract;
use pkmnfriends\Domain\Files\Files\Repositories\FilesRepository;

class FilesController extends ControllerAbstract
{

    /**
     * @var FilesRepository|null
     */
    public $rFiles = null;

    /**
     * MediasController constructor.
     *
     * @param FilesRepository $rFiles
     */
    public function __construct(FilesRepository $rFiles)
    {
        $this->rFiles = $rFiles;
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
            $document = $this->rFiles->streamPublicDocument($path);
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
            $thumbnail = $this->rFiles->streamPublicThumbnail($path);
        } catch (\Exception $exception) {
            abort(404);
        }

        return $thumbnail;
    }
}
