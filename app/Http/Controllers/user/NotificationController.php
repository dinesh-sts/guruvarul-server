<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\BlockProfile;
use App\Models\Ignore;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function notification(Request $request)
    {
        $log_inid = Auth::guard('user')->user();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
       
        $notification = 0;
        $registeruser = Register::whereNotIn('status',['Inactive','Suspended'])->pluck('matri_id')->toArray();
        $notify = Notification::whereNot('sender_id',$log_inid->matri_id)->whereIn('sender_id', $registeruser)->whereNotIn('sender_id', $ignore)->whereNotIn('sender_id', $blockuser)->where('receiver_id',$log_inid->matri_id)->OrderBy('created_at','desc')->get();
        if(count($notify) != 0)
        {
            foreach ($notify as $data) {
                $registerData = Register::where('matri_id', $data->sender_id)
                ->with('mother_tongue', 'rel', 'cast', 'occ', 'country', 'citi')
                ->where('matri_id', '!=', $log_inid->matri_id)
                ->first();
                if ($registerData) {
                    $notifications[] = [
                        'notify' => $data,
                        'registerData' => $registerData,
                    ];
                }            
            }
            $page = request()->get('page', 1);
            $perPage = 5; 
    
            $offset = ($page * $perPage) - $perPage;
           if(count($notifications) != 0)
           {
           
            $currentPageItems = array_slice($notifications, $offset, $perPage);
           
            $paginator = new LengthAwarePaginator(
                $currentPageItems,
                count($notifications),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            return view('user.notification',compact('paginator'));
           }
        }else{
            return view('user.notification');
        }
        
    }
    public function markread()
    {
        $log_inid = Auth::guard('user')->user();
        $notify = Notification::where('receiver_id',$log_inid->matri_id)->get();
       
        foreach ($notify as $data) {
            $data = Notification::FindOrFail($data->id);
            $data->seen = 1;
            $data->save();
        }
        return redirect()->back()->with('message','Notification marked readed.');
    }
}
