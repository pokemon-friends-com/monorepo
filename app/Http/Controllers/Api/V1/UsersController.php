<?php

namespace pkmnfriends\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use pkmnfriends\App\Events\DispatchFriendCodeOnStreamEvent;
use pkmnfriends\Domain\Users\Users\Notifications\DispatchFriendCodeOnStream;
use pkmnfriends\Domain\Users\Users\Presenters\TrainerChannelPresenter;
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
                    "https://api.qrserver.com/v1/create-qr-code/"
                    . "?size=300x300&format=png&data={$user->profile->friend_code}"
                )
                ->setName($user->profile->friend_code)
                ->setFileName("{$user->profile->friend_code}.png")
                ->toMediaCollection('trainer')
                ->toResponse($request);
        }

        return $user->profile->getMedia('trainer')->first()->toResponse($request);
    }

    /**
     * Get users twitch channels list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function channels()
    {
        $users = $this
            ->rUsers
            ->with(['profile'])
            ->whereHas('profile', function (Builder $query) {
                $query->whereNotNull('twitch_channel');
            })
            ->setPresenter(new TrainerChannelPresenter())
            ->paginate();

        return response()->json($users);
    }

    /**
     * Transmit friend code to a specific stream as qrcode image.
     *
     * @return \Illuminate\Http\Response
     */
    public function stream($channel, $friendCode)
    {
        broadcast(new DispatchFriendCodeOnStreamEvent($channel, $friendCode));

        return response()->noContent();
    }
}
