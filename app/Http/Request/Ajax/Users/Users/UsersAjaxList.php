<?php namespace obsession\Http\Request\Ajax\Users\Users;

use obsession\Infrastructure\Contracts\Request\RequestAbstract;

class UsersAjaxList extends RequestAbstract
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
            'user_id' => 'integer|exists:users,id',
            'users_ids' => 'array',
            'users_ids.*' => 'integer|exists:users,id',
            'roles_ids' => 'array',
            'roles_ids.*' => 'integer|exists:roles,id',
            'roles_names' => 'array',
            'roles_names.*' => 'max:255',
        ];

        return $rules;
    }
}
