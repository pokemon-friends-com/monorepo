<?php

namespace pkmnfriends\Http\Request\Administrator\Users\Users;

use Illuminate\Validation\Rule;
use pkmnfriends\Domain\Users\Profiles\ProfilesTeamsColors;
use pkmnfriends\Infrastructure\Contracts\Request\RequestAbstract;
use pkmnfriends\Domain\Users\Users\User;

class UserStoreFormRequest extends RequestAbstract
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
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|max:80|unique:users,email',
            'role' => 'required|in:'
                . User::ROLE_ADMINISTRATOR . ','
                . User::ROLE_CUSTOMER,
            'civility' => 'required|in:'
                . User::CIVILITY_MADAM . ','
                . User::CIVILITY_MISS . ','
                . User::CIVILITY_MISTER,
            'locale' => 'required|in:' . collect(User::LOCALES)->implode(','),
            'timezone' => 'required|in:' . collect(timezones())->implode(','),
        ];
    }
}
