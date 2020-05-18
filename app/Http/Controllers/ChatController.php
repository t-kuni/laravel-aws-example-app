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
        $body = $request->input('body');

        $msg = new Message();
        $msg->body = $body;
        $msg->save();

        broadcast(new MessageSend($body));

        return [];
    }

    public function list()
    {
        return Message::query()
            ->orderBy('id', 'desc')
            ->get()
            ->pluck('body');
    }
}
