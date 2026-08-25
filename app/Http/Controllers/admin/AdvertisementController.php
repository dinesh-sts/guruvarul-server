<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function advertisement(Request $request)
    {
        $filter = $request->input('filter');

        $query = Advertisement::select('id','adv_date','adv_name','adv_link','adv_level','adv_img','contact_name','phone','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('status', 'PENDING'); 
        }
        
        $advertisement = $query->orderByDesc('id')->get();

        $advertisementCount = Advertisement::count();

        $advertisementApprovedCount =Advertisement::where('status','APPROVED')->count();
        $advertisementUnapprovedCount =Advertisement::where('status','UNAPPROVED')->count();
        $advertisementPendingCount =Advertisement::where('status','PENDING')->count();

        return view('admin.advertisement.advertisementList',compact('advertisementPendingCount','advertisementUnapprovedCount','advertisementApprovedCount','advertisementCount','advertisement'));
    }

    public function advertisementCreate(){
        return view('admin.advertisement.advertisementCreate');
    }

    public function advertisementPost(Request $request){

        $request->validate([
            'adv_name' => 'required',
            'adv_link' => 'required|url',
            'adv_level' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'adv_img' => 'required'
        ]);

        $data = new Advertisement();
        $data->adv_date = Carbon::now();
        $data->adv_name = $request->adv_name;
        $data->adv_link = $request->adv_link;
        $data->adv_level = $request->adv_level;

        if ($request->has('adv_img')) {
           
            if ($request->hasFile('adv_img')) {
                
                $file = $request->file('adv_img');
                $imageFileType = $file->extension();
                $imageName = time().'.'.$imageFileType;  
        
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                }else{
                    $filePath = 'advImage/' . $imageName;
                    $file->storeAs('public', $filePath);
                    $data->adv_img = $imageName;
                }
            }
        }

        $data->contact_name = $request->contact_name;
        $data->phone = $request->phone;
        if($request->status){
            $data->status = $request->status;
        }else{
            $data->status = 'PENDING';
        }

        $data->save();
        return redirect()->back()->with('message','Data Stored Successfully');
    }

    public function advertisementEdit($id){

        $advertisement = Advertisement::findOrFail($id);

        return view('admin.advertisement.advertisementCreate',compact('advertisement'));
    }

    public function advertisementUpdate(Request $request,$id){

        $data = Advertisement::findOrFail($id);

        $request->validate([
            'adv_name' => 'required',
            'adv_link' => 'required|url',
            'adv_level' => 'required',
            'phone' => 'required|numeric|min:5',
            'status' => 'required',
        ]);

        $data->adv_date = Carbon::now();
        $data->adv_name = $request->adv_name;
        $data->adv_link = $request->adv_link;
        $data->adv_level = $request->adv_level;

        if ($request->has('adv_img')) {
            if ($request->hasFile('adv_img')) {
                
                $file = $request->file('adv_img');
                $imageFileType = $file->extension();
                $imageName = time().'.'.$imageFileType;  
        
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                }else{
                    Storage::disk('public')->delete('advImage/' . $data->adv_img);
                    $filePath = 'advImage/' . $imageName;
                    $file->storeAs('public', $filePath);
                    $data->adv_img = $imageName;
                }
            }
        }

        $data->contact_name = $request->contact_name;
        $data->phone = $request->phone;

        if($request->status){
            $data->status = $request->status;
        }else{
            $data->status = 'PENDING';
        }

        $data->save();

        return redirect()->back()->with('message','Data Updated Successfully');
    }

    public function advertisementDelete($id){

        $data = Advertisement::findOrFail($id);
        Storage::disk('public')->delete('advImage/' . $data->adv_img);
        $data->delete();

        return redirect()->back()->with('message','Data Deleted Successfully');
    }

    public function advertisementStatus(Request $request){

        $selectedIds = $request->input('selectedreligion');
        if($request->action == "approve"){
            Advertisement::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
            return redirect()->back()->with('message','Status Updated Sucessfully');
        }

        if($request->action == "unapprove"){
            Advertisement::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Status Updated Sucessfully');
        }
        if($request->action == "pending"){
            Advertisement::whereIn('id', $selectedIds)->update(['status' => 'PENDING']);
            return redirect()->back()->with('message','Status Updated Sucessfully');
        }

        if($request->action == "delete"){

            $images = Advertisement::whereIn('id', $selectedIds)->get();
            foreach($images as $data){
                Storage::disk('public')->delete('advImage/' . $data->adv_img);
            }
            Advertisement::whereIn('id', $selectedIds)->delete();
    
            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
