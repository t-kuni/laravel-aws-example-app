<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Item;
use App\Models\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('users', [
            'users' => User::all(),
        ]);
    }

    public function create(Request $request)
    {
        $name  = $request->input('name');
        $email = $request->input('email');

        $user           = new User();
        $user->name     = $name;
        $user->email    = $email;
        $user->password = '';
        $user->save();

        return redirect()->back()->with([
            'message' => 'ユーザを作成しました'
        ]);
    }

    public function detail(User $user)
    {
        $stripeCustomer     = $user->createOrGetStripeCustomer();
        $paymentMethods     = $user->paymentMethods();
        $plans              = collect([
            [
                'id'         => 'price_HKy9rkkmEs6Bu3',
                'title'      => '月額500円',
                'subscribed' => false,
            ],
            [
                'id'         => 'price_HL0N5ce980quhV',
                'title'      => '月額1000円',
                'subscribed' => false,
            ],
        ])->map(function ($plan) use ($user) {
            $plan['subscribed'] = $user->subscribedToPlan([$plan['id']], 'subscription-A');
            return $plan;
        });
        $plansSubscribed    = $plans->filter(function ($plan) {
            return $plan['subscribed'];
        });
        $plansNotSubscribed = $plans->filter(function ($plan) {
            return !$plan['subscribed'];
        });

        return view('user', [
            'user'               => $user,
            'intent'             => $user->createSetupIntent(),
            'stripeCustomer'     => $stripeCustomer,
            'paymentMethods'     => $paymentMethods,
            'plans'              => $plans,
            'plansSubscribed'    => $plansSubscribed,
            'plansNotSubscribed' => $plansNotSubscribed,
        ]);
    }
}
