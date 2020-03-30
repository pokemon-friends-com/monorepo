<?php

namespace template\Http\Controllers\Administrator\Users;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Domain\Users\Leads\Lead;
use template\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;

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
    }

    /**
     * Display list of resources.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $leads = $this->r_leads->getLeadsPaginated();

        return view('administrator.users.leads.index', compact('leads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Lead $lead
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Lead $lead)
    {
        $this->r_leads->createUserFromLead($lead);

        return redirect(route('administrator.users.leads.index'))
            ->with('message-success', trans('users.leads.lead_succefully_transformed_to_user'));
    }
}
