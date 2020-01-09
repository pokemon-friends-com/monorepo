<?php

namespace obsession\Http\Controllers\Api\V1\Users;

use Illuminate\Http\Request;
use obsession\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use obsession\Domain\Users\Users\Transformers\UserTransformer;
use obsession\Domain\Users\Users\User;
use obsession\Http\Request\Api\V1\Users\Profiles\ProfileFormRequest;
use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Infrastructure\Interfaces\Domain\Users\Profiles\ProfileFamiliesSituationsInterface;

class ProfilesController extends ControllerAbstract
{

    /**
     * @var ProfilesRepositoryEloquent|null
     */
    protected $r_profiles = null;

    /**
     * UserController constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profiles
     */
    public function __construct(ProfilesRepositoryEloquent $r_profiles)
    {
        $this->r_profiles = $r_profiles;
    }

    /**
     * Update user profile.
     *
     * @param User $user
     * @param ProfileFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, ProfileFormRequest $request)
    {
        try {
            $this
                ->r_profiles
                ->updateUserProfileWithRequest($request, $user->profile->id);

            $user = (new UserTransformer())->transform($user->refresh());
        } catch (\Prettus\Validator\Exceptions\ValidatorException $exception) {
            app('sentry')->captureException($exception);
        }

        return response()->json($user);
    }

    /**
     * Profile familly situations.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function familySituations(Request $request)
    {
        return response()->json(ProfileFamiliesSituationsInterface::FAMILY_SITUATIONS);
    }
}
