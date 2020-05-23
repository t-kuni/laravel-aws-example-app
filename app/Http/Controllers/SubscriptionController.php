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

    public function buy(Request $request)
    {
        $userID = $request->input('user_id');

        $user = User::find($userID);

        $user->newSubscription('default', 'premium')->create($paymentMethod);

        return redirect()->back();
    }
}
