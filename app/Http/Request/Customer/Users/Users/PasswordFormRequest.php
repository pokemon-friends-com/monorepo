<?php

namespace pkmnfriends\Http\Request\Customer\Users\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use pkmnfriends\Infrastructure\Contracts\Request\RequestAbstract;
use pkmnfriends\Domain\Users\Users\Repositories\UsersResetPasswordRepositoryEloquent;

class PasswordFormRequest extends RequestAbstract
{

    /**
     * @var UsersResetPasswordRepositoryEloquent
     */
    protected $rUsers;

    /**
     * PasswordFormRequest constructor.
     *
     * @param UsersResetPasswordRepositoryEloquent $rUsers
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(
        UsersResetPasswordRepositoryEloquent $rUsers,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct(
            $query,
            $request,
            $attributes,
            $cookies,
            $files,
            $server,
            $content
        );

        $this->rUsers = $rUsers;
    }

    /**
     * Determine if the user is authorized to make this request.
     * @SuppressWarnings("unused")
     *
     * @return bool
     */
    public function authorize()
    {
        Validator::extend(
            'validpassword',
            function ($attribute, $value, $parameters) {
                return Hash::check($value, Auth::user()->password);
            }
        );

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rUsers->getChangePasswordRules();
    }
}
