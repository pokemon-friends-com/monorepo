<?php

namespace obsession\Http\Controllers\Anonymous\Users;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class UsersController extends ControllerAbstract
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view(
            'anonymous.users.users.dashboard',
            [
                'metadata' => [
                    'title' => 'Obsession city',
                ],
            ]
        );
    }
}
