<?php

namespace pkmnfriends\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use pkmnfriends\Domain\Users\Profiles\Profile;
use pkmnfriends\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use pkmnfriends\Infrastructure\Contracts\Controllers\ControllerAbstract;
use pkmnfriends\Domain\Users\Users\Transformers\UserTransformer;
use pkmnfriends\Domain\Users\Users\User;

class UsersController extends ControllerAbstract
{

    /**
     * @var UsersRepositoryEloquent|null
     */
    protected $rUsers = null;

    /**
     * UserController constructor.
     *
     * @param UsersRepositoryEloquent $rUsers
     */
    public function __construct(UsersRepositoryEloquent $rUsers)
    {
        $this->rUsers = $rUsers;
    }

    /**
     * Get users list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->rUsers->with(['profile'])->all();

        return response()->json($users);
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
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\Response|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function qr(Request $request, User $user)
    {
        if (!$user || $user->deleted_at || !$user->profile->friend_code) {
            abort(404);
        }

        if (!$user->profile->hasMedia('trainer')) {
            return $user
                ->profile
                ->addMediaFromUrl(
                    'https://api.qrserver.com/v1/create-qr-code/'
                    . "?size=300x300&format=png&data={$user->profile->friend_code}"
                )
                ->setName($user->profile->friend_code)
                ->setFileName("{$user->profile->friend_code}.png")
                ->toMediaCollection('trainer')
                ->toResponse($request);
        }

        return $user->profile->getMedia('trainer')->first()->toResponse($request);
    }
}
