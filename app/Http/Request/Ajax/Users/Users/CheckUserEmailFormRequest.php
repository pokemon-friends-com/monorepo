<?php namespace obsession\Http\Request\Ajax\Users\Users;

use obsession\Infrastructure\Contracts\Request\RequestAbstract;

class CheckUserEmailFormRequest extends RequestAbstract
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
        $rules = [
            'email' => 'required|max:255',
            'not_user_id' => 'exists:users,uniqid',
        ];

        return $rules;
    }
}
