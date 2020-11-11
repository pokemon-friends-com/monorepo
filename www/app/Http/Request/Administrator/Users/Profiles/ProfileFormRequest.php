<?php

namespace pkmnfriends\Http\Request\Administrator\Users\Profiles;

use pkmnfriends\Infrastructure\Contracts\Request\RequestAbstract;
use pkmnfriends\Domain\Users\
{
    Users\User,
    Profiles\Profile
};

class ProfileFormRequest extends RequestAbstract
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
            'birth_date' => 'date_format:"' . trans('global.date_format') . '"',
            'family_situation' => 'in:'
                . Profile::FAMILY_SITUATION_SINGLE . ','
                . Profile::FAMILY_SITUATION_MARRIED . ','
                . Profile::FAMILY_SITUATION_CONCUBINAGE . ','
                . Profile::FAMILY_SITUATION_DIVORCEE . ','
                . Profile::FAMILY_SITUATION_WIDOW_ER,
            'maiden_name' => 'max:100',
            'timezone' => 'required|in:' . collect(timezones())->implode(','),
            'locale' => 'required|in:' . collect(User::LOCALES)->implode(','),
        ];

        return $rules;
    }
}
