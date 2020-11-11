<?php

namespace pkmnfriends\Http\Request\Customer\Users\Users;

use pkmnfriends\Infrastructure\Contracts\Request\RequestAbstract;

class ChangeEmailFormRequest extends RequestAbstract
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:80|unique:users',
        ];
    }
}
