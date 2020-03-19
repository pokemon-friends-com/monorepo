<?php

namespace template\Infrastructure\Contracts\Request;

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

    /**
     * Determine if the user is not a bot to make this request.
     *
     * @return bool
     * @throws \Exception
     */
    protected function recaptcha()
    {
        if (
            app()->environment('local')
            || app()->environment('testing')
        ) {
            return true;
        }

        $remoteUrl = sprintf(
            'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s',
            config('services.google_recaptcha.serverkey'),
            $this->get('g-recaptcha-response'),
            $_SERVER['REMOTE_ADDR']
        );

        $response = (new GuzzleHttpClient())
            ->request('GET', $remoteUrl);

        if (200 === $response->getStatusCode()) {
            $recaptchaResponse = json_decode($response->getBody());
        } else {
            throw new \Exception('Recaptcha verification failed!');
        }

        return $recaptchaResponse->success;
    }

    /**
     * ReCaptacha rule.
     *
     * @return array
     */
    protected function recaptchaRule()
    {
        $isEnvironmentNeedRule = app()->environment('local')
            || app()->environment('testing');

        return [
            'g-recaptcha-response' => $isEnvironmentNeedRule ? '' : 'required',
        ];
    }
}
