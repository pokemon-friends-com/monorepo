<?php

namespace obsession\Http\Controllers\Frontend;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class AboutController extends ControllerAbstract
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->before();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        return view('frontend.about.termsofservices', [
            'metadata' => [
                'title' => 'Terms of services',
            ],
        ]);
    }
}
