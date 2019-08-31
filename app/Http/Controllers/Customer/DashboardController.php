<?php namespace obsession\Http\Controllers\Customer;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class DashboardController extends ControllerAbstract
{

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->before();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return abort(503);
    }
}
