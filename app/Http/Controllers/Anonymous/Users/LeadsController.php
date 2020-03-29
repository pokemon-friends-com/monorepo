<?php

namespace template\Http\Controllers\Anonymous\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use template\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;
use template\Http\Request\Anonymous\Users\Leads\NewLeadRequest;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class LeadsController extends ControllerAbstract
{

    /**
     * @var LeadsRepositoryEloquent
     */
    public $r_leads;

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
     * Display contact form, to record new lead.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('anonymous.users.leads.index', [
            'metadata' => [
                'title' => trans('users.leads.contact'),
                'description' => trans('users.leads.anonymous.meta.description_contacts'),
            ],
            'civilities' => $this->r_leads->getCivilities(),
        ]);
    }

    /**
     * Store new lead then confirmation emails.
     *
     * @param NewLeadRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NewLeadRequest $request)
    {
        $lead = Auth::check() ? Auth::user() : null;

        if (!$lead) {
            $lead = $this
                ->r_leads
                ->qualifyLead(
                    $request->get('civility'),
                    $request->get('first_name'),
                    $request->get('last_name'),
                    $request->get('email')
                );
        }

        $lead
            ->sendHandshakeMailToConfirmReceptionToSenderNotification(
                $request->get('subject'),
                $request->get('message')
            );

        return redirect(route('anonymous.contact.index'))
            ->with('message-success', trans('users.leads.handshake_sent_success'));
    }
}
