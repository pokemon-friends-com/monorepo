<?php namespace obsession\Http\Controllers\Ajax;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;

class TimeZonesController extends ControllerAbstract
{

    /**
     * TimeZoneController constructor.
     */
    public function __construct()
    {
        $this->before();
    }

    /**
     * Get an times zones list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tzList = timezones();

        return response()->json($tzList);
    }
}
