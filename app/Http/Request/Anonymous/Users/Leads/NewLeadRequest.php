<?php

namespace template\Http\Request\Anonymous\Users\Leads;

use template\Domain\Users\Users\User;
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
                'civility' => 'required|in:'
                    . User::CIVILITY_MADAM . ','
                    . User::CIVILITY_MISS . ','
                    . User::CIVILITY_MISTER,
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'required|email|max:80',
                'subject' => 'required|max:255',
                'message' => 'required',
                'certify' => 'required',
            ];
    }
}
