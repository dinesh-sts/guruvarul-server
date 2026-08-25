<?php

namespace App\Http\Controllers\admin\userActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatThread;
use App\Models\Chat;

class MessageUserActivityController extends Controller{

    public function messageActivity(Request $request){
        $messageactivity = [];
        $chats = Chat::orderBy('created_at','desc')->with('sender')->get();
        
        foreach($chats as $chat){
    
            $ChatThread = ChatThread::where('id',$chat->chat_thread_id)->with('sender','receiver')->select('id','sender_user_id','receiver_user_id')->first();
    
            $messageactivity[] = [
                'ChatThread' => $ChatThread, 
                'data' => $chat,
            ];
        }

        return view('admin.userActivity.messageActivity',compact('messageactivity'));
    }

    public function messageActivityDelete(Request $request,$id){

        $chats = Chat::findOrFail($id);

        foreach($chats as $chat){
            $ChatThread = ChatThread::where('id',$chats->chat_thred_id)->delete();
        }

        $chats->delete();

        return redirect()->route('admin.messageActivity')->with('message','Message Deleted Sucessfully');
    }

    public function messageActivityStatus(Request $request){

        $selectedIds = $request->input('selected');

        if($request->action == "delete"){

            $chats = Chat::whereIn('id',$selectedIds)->delete();
            return redirect()->back()->with('message','Data Deleted Sucessfully');

        }
    }
}
