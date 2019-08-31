<?php namespace obsession\Http\Controllers\Ajax;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Infrastructure\Interfaces\Domain\Locale\LocalesInterface;

class LocalesController extends ControllerAbstract
{

    /**
     * LocalesController constructor.
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
        $localeList = LocalesInterface::LOCALES;

        return response()->json($localeList);
    }
}
