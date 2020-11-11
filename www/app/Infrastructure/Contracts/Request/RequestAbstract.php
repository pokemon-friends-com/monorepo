<?php

namespace pkmnfriends\Infrastructure\Contracts\Request;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Foundation\Http\FormRequest;

abstract class RequestAbstract extends FormRequest
{

    /**
     * {inherit}
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return parent::get($key, $default);
    }

    /**
     * {inherit}
     *
     * @param array|string $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return parent::has($key);
    }
}
