<?php

namespace pkmnfriends\Http\Request\Administrator\Users\Users;

use pkmnfriends\Infrastructure\Contracts\Request\RequestAbstract;

class UsersFiltersFormRequest extends RequestAbstract
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
            'full_name' => 'max:255',
            'email' => 'max:255',
        ];
    }
}
