<?php namespace obsession\Http\Controllers\Backend\Users;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;

class LeadsController extends ControllerAbstract
{

    /**
     * @var null
     */
    protected $r_leads = null;

    /**
     * LeadsController constructor.
     *
     * @param LeadsRepositoryEloquent $r_leads
     */
    public function __construct(LeadsRepositoryEloquent $r_leads)
    {
        $this->r_leads = $r_leads;

        $this->before();
    }

    /**
     * Display list of resources.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        try {
            $leads = $this->r_leads->getLeadsPaginated();
        } catch (\Exception $exception) {
            app('sentry')->captureException($exception);
        }

        return view('backend.users.leads.index', compact('leads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param integer $id Lead id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update($id)
    {
        try {
            $this->r_leads->createUserFromLead($id);
        } catch (\Prettus\Validator\Exceptions\ValidatorException $exception) {
            app('sentry')->captureException($exception);
        }

        return redirect(route('backend.leads.index'))
            ->with('message-success', trans('leads.lead_succefully_transformed_to_user'));
    }
}
