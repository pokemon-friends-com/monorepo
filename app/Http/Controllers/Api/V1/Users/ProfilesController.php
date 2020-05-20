<?php

namespace template\Http\Controllers\Api\V1\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use template\Domain\Users\Profiles\Criterias\NotAuthenticatedLimitCriteria;
use template\Domain\Users\Profiles\Criterias\WhereSponsoredCriteria;
use template\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;
use template\Domain\Users\Users\Transformers\UserTransformer;
use template\Domain\Users\Users\User;
use template\Http\Request\Api\V1\Users\Profiles\ProfileFormRequest;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Infrastructure\Interfaces\Domain\Users\Profiles\ProfileFamiliesSituationsInterface;

class ProfilesController extends ControllerAbstract
{

    /**
     * @var ProfilesRepositoryEloquent|null
     */
    protected $rProfiles = null;

    /**
     * UserController constructor.
     *
     * @param ProfilesRepositoryEloquent $rProfiles
     */
    public function __construct(ProfilesRepositoryEloquent $rProfiles)
    {
        $this->rProfiles = $rProfiles;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (!Auth::guard('api')->check()) {
            $this
                ->rProfiles
                ->pushCriteria(NotAuthenticatedLimitCriteria::class)
                ->pushCriteria(WhereSponsoredCriteria::class);
        }

        $profiles = $this
            ->rProfiles
            ->paginate();

        return response()->json($profiles);
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
                ->rProfiles
                ->updateUserProfileWithRequest($request, $user);

            $user = (new UserTransformer())->transform($user->refresh());
        } catch (\Prettus\Validator\Exceptions\ValidatorException $exception) {
            app('sentry')->captureException($exception);
        }

        return response()->json($user);
    }

    /**
     * Profile family situations.
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
