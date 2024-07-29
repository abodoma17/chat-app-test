<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Jobs\SendMessageJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::findAllExceptIds(Auth::id());
        return view('chat.index', compact('users'));
    }

    public function sendMessage(Request $request)
    {
        Queue::push(new SendMessageJob($request->get('senderUserId'), $request->get('receiverUserId'), $request->get('message')));
        return;
    }
}
