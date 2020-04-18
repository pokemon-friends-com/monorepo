<?php

namespace template\Http\Controllers\Api\V1\Users;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Users\Users\Transformers\UserTransformer;
use template\Domain\Users\Users\User;

class UsersController extends ControllerAbstract
{

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $r_users = null;

    /**
     * UserController constructor.
     *
     * @param UsersRepositoryEloquent $r_users
     */
    public function __construct(UsersRepositoryEloquent $r_users)
    {
        $this->r_users = $r_users;
    }

    /**
     * Get User.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $user = (new UserTransformer())->transform($user);

        return response()->json($user);
    }

    /**
     * Get the authenticated User.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return $this->show($request->user());
    }

    /**
     * Get user QR code image.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function qr(User $user)
    {
        if (!$user || $user->deleted_at || !$user->profile->friend_code) {
            abort(404);
        }

        if (Cache::has("qr_code_png.{$user->profile->friend_code}")) {
            $qr = Cache::get("qr_code_png.{$user->profile->friend_code}");
        } else {
            $qr = $this->qrServer($user->profile->friend_code);
            $expiresAt = Carbon::now()->addMinutes(4320); // 72 hours
            Cache::put("qr_code_png.{$user->profile->friend_code}", $qr, $expiresAt);
        }

        return response()->make($qr, 200, ['Content-Type' => 'image/png']);
    }

    /**
     * Get user QR code image from qrserver.
     *
     * @param string $data
     *
     * @return string
     */
    public function qrServer(string $data)
    {
        return (new Client([
            'base_uri' => 'https://api.qrserver.com/v1/create-qr-code/'
                . "?size=300x300&format=png&data={$data}",
        ]))
            ->request('GET')
            ->getBody()
            ->getContents();
    }

    /**
     * Get user QR code image from google.
     *
     * @param string $data
     *
     * @return string
     */
    //public function qrGoogle(string $data)
    //{
    //    return (new Client([
    //        'base_uri' => 'https://chart.googleapis.com/chart'
    //            . "?cht=qr&chs=300x300&choe=UTF-8&chld=L|0&chl={$data}",
    //    ]))
    //        ->request('GET')
    //        ->getBody()
    //        ->getContents();
    //}
}
