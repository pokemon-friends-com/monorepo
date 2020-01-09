<?php

namespace obsession\Http\Controllers\Anonymous;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class AboutController extends ControllerAbstract
{

    /**
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
