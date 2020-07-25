<?php

namespace pkmnfriends\Http\Controllers\OAuth;

use Carbon\Carbon;
use Laravel\Passport\PersonalAccessTokenResult;

trait LoginResponseTrait
{

    /**
     * @param PersonalAccessTokenResult $userToken
     * @param integer $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createLoginResponse(
        PersonalAccessTokenResult $userToken,
        int $status = 200
    ) {
        return response()
            ->json(
                [
                    'access_token' => $userToken->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($userToken->token->expires_at)
                        ->toDateTimeString()
                ],
                $status
            );
    }
}
