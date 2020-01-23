<?php

namespace template\Http\Controllers\Anonymous\Users;

use template\Infrastructure\Contracts\Controllers\ControllerAbstract;
use template\Http\Request\Anonymous\Contacts\ContactRequest;
use template\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;

class LeadsController extends ControllerAbstract
{

    /**
     * @var LeadsRepositoryEloquent|null
     */
    public $r_leads = null;

    /**
     * LeadsController constructor.
     * @param LeadsRepositoryEloquent $r_leads
     */
    public function __construct(LeadsRepositoryEloquent $r_leads)
    {
        $this->r_leads = $r_leads;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('anonymous.users.leads.index', [
            'metadata' => [
                'title' => trans('leads.contacts'),
            ],
            'civilities' => $this->r_leads->getCivilities()
        ]);
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ContactRequest $request)
    {
        $validator = \Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return redirect(route('anonymous.users.leads.index'))
                ->withErrors($validator->failed());
        }

        $validatedContact = $validator->validate();

        $this
            ->r_leads
            ->qualifyLead(
                $validatedContact['civility'],
                $validatedContact['first_name'],
                $validatedContact['last_name'],
                $validatedContact['email']
            )
            ->sendHandshakeMailToConfirmReceptionToSenderNotification(
                $validatedContact['subject'],
                $validatedContact['message']
            );

        return redirect(route('anonymous.contact.index'))
            ->with('message-success', trans('frontend/contacts.alert_send_success'));
    }
}
