<?php

namespace template\Http\Controllers\Administrator\Files;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Files\Files\Repositories\FilesRepository;

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
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(
            'administrator.files.files.index',
            $this->r_files->getViewVars()
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connector()
    {
        return $this->r_files->connector();
    }
}
