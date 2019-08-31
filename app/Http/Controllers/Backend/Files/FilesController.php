<?php namespace obsession\Http\Controllers\Backend\Files;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Domain\Files\Files\Repositories\FilesRepository;

class FilesController extends ControllerAbstract
{

    /**
     * @var null
     */
    protected $r_files = null;

    /**
     * FilesController constructor.
     *
     * @param FilesRepository $r_files
     */
    public function __construct(FilesRepository $r_files)
    {
        $this->r_files = $r_files;

        $this->before();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->r_files->backendShowIndexView();
    }

    /**
     * @return mixed
     */
    public function ckeditor()
    {
        return $this->r_files->backendShowCKeditor4();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connector()
    {
        return $this->r_files->backendShowConnector();
    }
}
