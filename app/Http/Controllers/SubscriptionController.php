<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Item;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        return view('subscription');
    }

    public function buy(Request $request)
    {
        return redirect()->back();
    }
}
