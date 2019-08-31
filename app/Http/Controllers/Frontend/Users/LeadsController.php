<?php namespace obsession\Http\Controllers\Frontend\Users;

use obsession\Infrastructure\Contracts\Controllers\ControllerAbstract;
use obsession\Http\Request\Frontend\Contacts\ContactRequest;
use obsession\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;

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

        $this->before();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.users.leads.index', [
            'metadata' => [
                'title' => 'Get in touch',
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
            return redirect(route('frontend.contact.index'))
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

        return redirect(route('frontend.contact.index'))
            ->with('message-success', trans('frontend/contacts.alert_send_success'));
    }
}
