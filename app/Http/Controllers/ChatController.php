<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Item;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    //
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $msg = new Message();
        $msg->body = $request->input('body');
        $msg->save();

        event(new MessageSend());

        return redirect()->back();
    }
}
