<?php

namespace pkmnfriends\Http\Controllers\Anonymous\Users;

use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Illuminate\Support\Facades\Auth;
use pkmnfriends\Infrastructure\Contracts\Controllers\ControllerAbstract;

class CreateSubscriptionController extends ControllerAbstract
{
    /**
     * @param string $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(string $plan)
    {
        $user = Auth::user();

        $name = ucfirst($plan) . ' membership';

        if (!$user->profile->subscribed($name, $plan)) {
            $result = $user->profile->newSubscription($name, $plan)->create();

            if (is_a($result, RedirectToCheckoutResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }

            return back()->with('status', 'Welcome to the ' . $plan . ' plan');
        }

        return back()->with('status', 'You are already on the ' . $plan . ' plan');
    }
}
