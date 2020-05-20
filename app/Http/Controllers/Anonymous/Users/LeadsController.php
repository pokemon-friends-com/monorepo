<?php

namespace template\Http\Controllers\Anonymous\Users;

use Illuminate\Support\Facades\Auth;
use template\Domain\Users\Leads\Repositories\LeadsRepositoryEloquent;
use template\Domain\Users\Users\Repositories\UsersRepositoryEloquent;
use template\Http\Request\Anonymous\Users\Leads\NewLeadRequest;
use template\Infrastructure\Contracts\Controllers\ControllerAbstract;

class LeadsController extends ControllerAbstract
{

    /**
     * @var UsersRepositoryEloquent
     */
    protected $rUsers;

    /**
     * @var LeadsRepositoryEloquent
     */
    public $rLeads;

    /**
     * LeadsController constructor.
     *
     * @param UsersRepositoryEloquent $rUsers
     * @param LeadsRepositoryEloquent $rLeads
     */
    public function __construct(
        UsersRepositoryEloquent $rUsers,
        LeadsRepositoryEloquent $rLeads
    ) {
        $this->rUsers = $rUsers;
        $this->rLeads = $rLeads;
    }

    /**
     * Display contact form, to record new lead.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $metadata = [
            'title' => trans('users.leads.contact'),
            'description' => trans('users.leads.anonymous.meta.description_contacts'),
        ];
        $users = $this
            ->rUsers
            ->getTrainers()
            ->paginate(config('repository.pagination.limit'));
        $civilities = $this->rLeads->getCivilities();
        
        return view('anonymous.users.leads.index', compact(
            'metadata',
            'users',
            'civilities',
        ));
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
                ->rLeads
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
