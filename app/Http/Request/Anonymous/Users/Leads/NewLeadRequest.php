<?php

namespace template\Http\Request\Anonymous\Users\Leads;

use template\Infrastructure\Contracts\Request\RequestAbstract;

class NewLeadRequest extends RequestAbstract
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws \Exception
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
