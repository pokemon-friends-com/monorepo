<?php

namespace template\Http\Controllers\Administrator\Settings;

use Illuminate\Http\Request;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class SettingsController extends ControllerAbstract
{

    /**
     * Show settings resources.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index()
    {
        return view('administrator.settings.settings.index');
    }

    /**
     * Store settings resources.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function store(Request $request)
    {
        dd($request->all());
    }
}
