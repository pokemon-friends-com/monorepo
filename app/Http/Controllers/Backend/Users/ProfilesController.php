<?php namespace obsession\Http\Controllers\Backend\Users;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Http\Request\Backend\Users\Profiles\
{
    ProfileFormRequest
};
use obsession\Domain\Users\Profiles\Repositories\ProfilesRepositoryEloquent;

class ProfilesController extends ControllerAbstract
{

    /**
     * @var null
     */
    protected $r_profiles = null;

    /**
     * ProfilesController constructor.
     *
     * @param ProfilesRepositoryEloquent $r_profiles
     */
    public function __construct(ProfilesRepositoryEloquent $r_profiles)
    {
        $this->r_profiles = $r_profiles;

        $this->before();
    }

    /**
     * Display list of resources.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->r_profiles->backendIndexView();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param integer $id Profile id
     * @param ProfileFormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, ProfileFormRequest $request)
    {
        return $this->r_profiles->backendUpdateWithRedirection($request, $id);
    }
}
