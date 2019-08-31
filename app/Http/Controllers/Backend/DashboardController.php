<?php

namespace obsession\Http\Controllers\Backend;

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
//        try {
//
//
//
//        } catch (\Exception $exception) {
//            app('sentry')->captureException($exception);
//
//            return abort('404');
//        }

        return view('backend.dashboard.dashboard.index', []);
    }
}
