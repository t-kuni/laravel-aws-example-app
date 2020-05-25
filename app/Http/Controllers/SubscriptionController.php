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
        $paymentMethods = $user->paymentMethods();
        $paymentMethod  = $paymentMethods[0];
        $user->newSubscription('subscription-A', 'price_HKy9rkkmEs6Bu3')->create($paymentMethod->id);

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
}
