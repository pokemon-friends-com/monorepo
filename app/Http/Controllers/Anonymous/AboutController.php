<?php

namespace template\Http\Controllers\Anonymous;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class AboutController extends ControllerAbstract
{

    /**
     * Display terms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        return view('anonymous.about.termsofservices', [
            'metadata' => [
                'title' => 'Terms of services',
            ],
        ]);
    }
}
