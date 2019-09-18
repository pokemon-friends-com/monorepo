<?php namespace obsession\Http\Controllers\Frontend;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class HomeController extends ControllerAbstract
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->before();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(
            'frontend.home.index',
            [
                'metadata' => [
                    'title' => 'Obsession city',
                ],
            ]
        );
    }
}
