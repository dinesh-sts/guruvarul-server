<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatThread;
use App\Models\Notification;
use App\Models\Register;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class MessageController extends Controller
{
    public function chatthreadpost(Request $request,$id)
    {
        $user_id = Auth::guard('user')->user();
        // $data = ChatThread::where('sender_user_id', $user_id->id)->where('receiver_user_id', $id)->first();
        $data = ChatThread::where('sender_user_id', $id)->where('receiver_user_id', $user_id->id)->first();
        if($data == null)
        {
            $data = ChatThread::where('receiver_user_id',$id)->where('sender_user_id',$user_id->id)->first();
        }
        if($data == null)
        {
            $ChatThread = new ChatThread();
            $ChatThread->thread_code = $user_id->matri_id;
            $ChatThread->sender_user_id  = $user_id->id;
            $ChatThread->receiver_user_id  = $id;
            $ChatThread->active  = 1;
            $ChatThread->interview  = 1;
            if($request->attachment != null){
                $ChatThread->attachment = json_encode(explode(',', $request->attachment));
            }
            $ChatThread->save();
            Session::put('receiver_user_id', $id);
            return redirect()->route('user.message');
        }else{
            Session::put('receiver_user_id', $id);
            return redirect()->route('user.message');
        }
    }

    public function deleteRecord(Request $request)
    {
        $user_id = Auth::guard('user')->user();
        $id = $request->session()->get('receiver_user_id');
      //  $ChatThreads = ChatThread::where('sender_user_id', $id)->OrWhere('receiver_user_id', $user_id)->where('sender_user_id',$user_id->id)->orwhere('receiver_user_id',$id)->get();
           $ChatThreads = ChatThread::where('sender_user_id', $user_id->id)->get();
            foreach($ChatThreads as $ChatThread)
            {
                $data = Chat::where('chat_thread_id', $ChatThread->id)->where('sender_user_id', $user_id->id)->first();
                if($data == NULL)
                {
                    $data = ChatThread::where('id', $ChatThread->id)->delete();
                    Session::flash('receiver_user_id');
                }
            }
        return response()->json(['success' => true]);
    }
    
    public function message(Request $request)
    {
            $user_id = Auth::guard('user')->user();
            $chatthreadids = ChatThread::where('receiver_user_id', $user_id->id)->pluck('id')->toArray();

            $chatids = Chat::whereIn('chat_thread_id', $chatthreadids)->pluck('chat_thread_id')->toArray();
            $chat_threads = ChatThread::where(function($query) use ($chatids, $user_id) {
                if (!empty($chatids)) {
                    $query->whereIn('id', $chatids)
                          ->orWhere('sender_user_id', $user_id->id);
                } else {
                    $query->where('sender_user_id', $user_id->id)->orWhere('receiver_user_id', $user_id->id);
                }
            })->OrderBy('created_at','desc')->get();
          
          //$chat_threads = ChatThread::where('sender_user_id', $user_id->id)->orWhere('receiver_user_id', $user_id->id)->OrderBy('created_at','desc')->get();
            return view('user.message.message',compact('chat_threads'));
       
    }

    public function chat_view($id)
    {
        Session::forget('message_id');
        Session::forget('last_id');
        Session::forget('totalCount');
        $user_id = Auth::guard('user')->user()->id;
       
            $chat_thread = ChatThread::findOrFail($id);
              foreach ($chat_thread->chats as $key => $chat) {
                if($chat->sender_user_id != $user_id){
                    $chat->seen = 1;
                    $chat->save();
                }
              }
              $chats = $chat_thread->chats()->latest()->limit(5)->get();
   
        return view('user.message.viewmessage', compact('chats', 'chat_thread'));
    }
    
    public function getoldmessages(Request $request)
    {
        $message_id = $request->session()->get('last_id');
        if($message_id != "")
        {
            $chat = Chat::findOrFail($request->session()->get('message_id'));
        }else{
            $chat = Chat::findOrFail($request->first_message_id);
        }
    
       $totcount = Chat::where('chat_thread_id', $chat->chat_thread_id)->count();

        $chats = Chat::where('id', '<', $chat->id)->where('chat_thread_id', $chat->chat_thread_id)->latest()->limit(10)->get();
        $currentcount = $chats->count();

        $totalcount = $request->session()->get('totalCount');
        if ($currentcount > 0) {
          
            $totalcount += $currentcount;
           
        }
        if($totcount <=$totalcount)
        {
            return array('messages' => "",
                         'first_message_id' => 0);
        }

        if(count($chats) > 0){
            session::put('totalCount',$totalcount);
            session::put('message_id',$chats->last()->id);
            session::put('last_id',$chat->id);
            return array('messages' => view('user.message.messagepart', compact('chats'))->render(),
                         'first_message_id' => $chats->last()->id);
        }
        else {
            return array('messages' => "",
                         'first_message_id' => 0);
        }
    }

    public function chat_refresh($id)
    {
        $user_id = Auth::guard('user')->user();
        $chat_thread = ChatThread::findOrFail($id);
        $chats = $chat_thread->chats()->where('sender_user_id', '!=', $user_id->id)->where('seen' , 0)->get();
        foreach ($chats as $key => $value) {
            $value->seen = 1;
            $value->save();
        }
        return array('messages' => view('user.message.messages_left_single', compact('chats'))->render(),
                     'count' => count($chats));

    }

    public function chat_reply(Request $request)
    {
        $user_id = Auth::guard('user')->user();
        $chat = new Chat;
        $chat->chat_thread_id = $request->chat_thread_id;
        $chat->sender_user_id = $user_id->id;
        $chat->message = $request->message;
        $chat->save();
        if($chat){
                $id = $request->chat_thread_id;
               
                $chat_thread = ChatThread::findOrFail($id);
                if($chat_thread->receiver_user_id == $user_id->id)
                {
                    $register = Register::where('id',$chat_thread->sender_user_id)->first();
                }else{
                    $register = Register::where('id',$chat_thread->receiver_user_id)->first();
                }
                
                $notificationCheck = Notification::where('sender_id',$user_id->matri_id)->orWhere('notification_type','Message')->first();
                //dd($notificationCheck->sender_id);

                if($notificationCheck == NULL ){
                    $notification = new Notification();
                    $notification->sender_id  = $user_id->matri_id;
                    $notification->receiver_id  = $register->matri_id;
                    $notification->notification_type  = "Message";
                    $notification->notification  = "One New Message Received From";
                    $notification->seen  = 0;
                    $notification->date = Carbon::now();
                
                    $notification->save();
                }
            }
      
        return view('user.message.messages_right_single', compact('chat'));
    }
    
}
