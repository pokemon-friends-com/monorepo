<?php

namespace template\Http\Controllers\Anonymous\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Http\Request\Anonymous\Users\Leads\NewLeadRequest;
use template\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;

class LeadsController extends ControllerAbstract
{

    /**
     * @var LeadsRepositoryEloquent|null
     */
    public $r_leads = null;

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
                'title' => trans('leads.contacts'),
            ],
            'civilities' => $this->r_leads->getCivilities(),
        ]);
    }

    /**
     * Store new lead.
     *
     * @param NewLeadRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NewLeadRequest $request)
    {
        $lead = null;
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect(route('anonymous.users.leads.index'))
                ->withErrors($validator->failed());
        }

        $validatedContact = $validator->validate();

        if (Auth::check()) {
            $lead = Auth::user();
        } else {
            $lead = $this
                ->r_leads
                ->qualifyLead(
                    $validatedContact['civility'],
                    $validatedContact['first_name'],
                    $validatedContact['last_name'],
                    $validatedContact['email']
                );
        }

        $lead
            ->sendHandshakeMailToConfirmReceptionToSenderNotification(
                $validatedContact['subject'],
                $validatedContact['message']
            );

        return redirect(route('anonymous.contact.index'))
            ->with('message-success', trans('frontend/contacts.alert_send_success'));
    }
}
