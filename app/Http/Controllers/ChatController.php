<?php
namespace App\Http\Controllers;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\User;
use App\Message;

class ChatController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  
  public function chat()
  {
    return view('chat');
  }

  public function send(Request $request)
  {
    $user = User::find(auth()->user()->id);
    $message = new Message;
    $message->name = $user->name;
    $message->message = $request->message;
    $message->created_at = $request->tm;
    $message->save();
    broadcast(new ChatEvent($request->message, $user, $request->tm))->toOthers();
  }

  public function getMessages()
  {
    $messages = Message::orderBy('created_at', 'desc')->take(10)->get();
    return response()->json($messages);
  }
}
