<?php namespace obsession\Infrastructure\Contracts\Request;

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

    protected function recaptcha()
    {
        if (
            app()->environment('local')
            || app()->environment('testing')
        ) {
            return true;
        }

        $recaptchaIp = $_SERVER['REMOTE_ADDR'];
        $recaptchaKey = config('services.google_recaptcha.serverkey');
        $recaptchaResponse = $this->get('g-recaptcha-response');

        $recaptchaResponse = file_get_contents(sprintf(
            "https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s",
            $recaptchaKey,
            $recaptchaResponse,
            $recaptchaIp
        ));

        $recaptchaResponse = json_decode($recaptchaResponse);

        return $recaptchaResponse->success;
    }

    protected function recaptchaRule()
    {
        $isEnvironmentNeedRule = app()->environment('local')
            || app()->environment('testing');

        return [
            'g-recaptcha-response' => $isEnvironmentNeedRule ? '' : 'required',
        ];
    }
}
