<?php

namespace obsession\Http\Request\Anonymous\Contacts;

use obsession\Infrastructure\Contracts\Request\RequestAbstract;

class ContactRequest extends RequestAbstract
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->recaptcha();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->recaptchaRule()
            + [
                'civility' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
                'certify' => 'required',
            ];
    }
}
