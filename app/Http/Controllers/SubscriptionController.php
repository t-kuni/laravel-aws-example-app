<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Item;
use App\Models\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        return view('subscription', [
            'users' => User::all(),
        ]);
    }

    public function card(Request $request, User $user)
    {
        $paymentMethod = $request->input('payment_method');
        $user->updateDefaultPaymentMethod($paymentMethod);
        return redirect()->back();
    }

    public function buy(Request $request, User $user)
    {
        $planId    = $request->input('plan_id');
        $quantity  = intval($request->input('amount'));
        $trialDays = intval($request->input('trial_days', 0));
        $coupon = $request->input('coupon');

        $paymentMethods = $user->paymentMethods();
        $paymentMethod  = $paymentMethods[0];

        $query = $user->newSubscription('subscription-A', $planId)
            ->quantity($quantity);

        if ($trialDays > 0) {
            $query->trialDays($trialDays);
        }

        if (!empty($coupon)) {
            $query->withCoupon($coupon);
        }

        $query->create($paymentMethod->id);

        return redirect()->back();
    }

    public function swap(Request $request, User $user)
    {
        $planId = $request->input('plan_id');

        $user->subscription('subscription-A')->swap($planId);

        return redirect()->back();
    }

    public function cancel(Request $request, User $user)
    {
        $user->subscription('subscription-A')->cancel();

        return redirect()->back();
    }

    public function forceCancel(Request $request, User $user)
    {
        $user->subscription('subscription-A')->cancelNow();

        return redirect()->back();
    }
}
