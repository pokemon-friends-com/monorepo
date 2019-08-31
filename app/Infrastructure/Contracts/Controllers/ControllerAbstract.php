<?php namespace obsession\Infrastructure\Contracts\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;

abstract class ControllerAbstract extends BaseController
{

    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * DRY method to run before any method
     */
    public function before()
    {
    }
}
