<?php

namespace pkmnfriends\Http\Request\Customer\Users\Profiles;

use pkmnfriends\Infrastructure\Contracts\Request\RequestAbstract;
use pkmnfriends\Domain\Users\{Profiles\ProfilesTeamsColors,
    Users\User,
    Profiles\Profile};

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
            'nickname' => 'required|string|max:35',
            'twitch_channel' => 'string|max:25',
            'friend_code' => 'required|string|numeric|digits:12',
            'team_color' => 'required|in:'
                . ProfilesTeamsColors::DEFAULT . ','
                . ProfilesTeamsColors::RED . ','
                . ProfilesTeamsColors::BLUE . ','
                . ProfilesTeamsColors::YELLOW,
            'first_name' => 'max:100',
            'last_name' => 'max:100',
            'birth_date' => 'date_format:' . trans('global.date_format'),
            'civility' => 'required|in:'
                . User::CIVILITY_MADAM . ','
                . User::CIVILITY_MISS . ','
                . User::CIVILITY_MISTER,
            'timezone' => 'required|in:' . collect(timezones())->implode(','),
            'locale' => 'required|in:' . collect(User::LOCALES)->implode(','),
        ];

        return $rules;
    }
}
