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
        $stripeCustomer = $user->createOrGetStripeCustomer();
        $paymentMethods = $user->paymentMethods();

        return view('user', [
            'user'           => $user,
            'intent'         => $user->createSetupIntent(),
            'stripeCustomer' => $stripeCustomer,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
