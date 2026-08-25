<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuccessStory;
use App\Http\Requests\SuccessStoryRequest;
use Illuminate\Support\Facades\Storage;
//use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SuccessStoryController extends Controller{

    // Success Story List
    public function successStory(Request $request){
        $filter = $request->input('filter');

        $query = SuccessStory::select('id','weddingphoto','bridename','brideid','groomname','groomid','marriagedate','engagement_date','successmessage','status','created_at');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $stories = $query->orderByDesc('id')->get();
        $storiesCount = SuccessStory::count();
        $storiesApprovedCount =SuccessStory::where('status',"APPROVED")->count();
        $storiesUnapprovedCount =SuccessStory::where('status',"UNAPPROVED")->count();

        return view('admin.successStory.storyList',compact('storiesUnapprovedCount','storiesApprovedCount','storiesCount','stories'));
    }

    // Single delete
    public function successStoryDelete(Request $request,$id){
        $story = SuccessStory::findOrFail($id);
        $story->delete();
        return redirect()->route('admin.successStoryList')->with('message', 'Data Deleted Sucessfully');
    }


    // Multiple action bar
    public function successStoryStatus(Request $request){
     
        $selectedIds = $request->input('selected');
        if($request->action == "approve"){
            SuccessStory::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
            return redirect()->back()->with('message','All Status Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            SuccessStory::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
            return redirect()->back()->with('message','All Status UnApproved Sucessfully');
        }

        if($request->action == "delete"){
           $images = SuccessStory::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('successStory/' . $image->weddingphoto);
            }
            SuccessStory::whereIn('id', $selectedIds)->delete();

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }

    }

    // Success story create view
    public function successStoryCreate(){
        return view('admin.successStory.storyCreate');
    }
    

    // Store success story
    public function successStoryStore(SuccessStoryRequest $request){

        $data = new SuccessStory();
        if ($request->has('weddingphoto')) {
            if ($request->hasFile('weddingphoto')) {
                $file = $request->file('weddingphoto'); 
                $imageFileType = $request->weddingphoto->extension();
                $imageFilesize = $request->weddingphoto->getSize();
                $imageName = time().'.'.$imageFileType; 
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                }elseif($imageFilesize > 4000000) {
                    return redirect()->back()->with('message','your file size is more than 4MB.');
                }else{
                    $imageManager = new ImageManager(new Driver());
                    $thumbImage = $imageManager->read($file);

                    $resizedImage = $thumbImage->resize(1660, 1100)->toJpeg(90);
                    
                    Storage::disk('public')->put('successStory/' . $imageName, $resizedImage);
                    $data->weddingphoto = $imageName;
                }
            }
        }
        $data->bridename = $request->bridename;
        $data->brideid = $request->brideid;
        $data->groomname = $request->groomname;
        $data->groomid = $request->groomid;
        $data->marriagedate = $request->marriagedate;
        $data->engagement_date = $request->engagement_date;
        $data->successmessage = $request->successmessage;
        $data->status = 'APPROVED';
        $data->save();
        return redirect()->route('admin.successStoryCreate')->with('message', 'Success story added successfully.');
    }

    // Edit success story view
    public function successStoryEdit(Request $request,$id){
        $story = SuccessStory::findOrFail($id);
        return view('admin.successStory.storyCreate',compact('story'));
    }

    // Edit success story
    public function successStoryUpdate(SuccessStoryRequest $request,$id){
        $data = SuccessStory::FindOrFail($id);
        if ($request->has('weddingphoto')) {
          
            if ($request->hasFile('weddingphoto')) {
                $file = $request->file('weddingphoto'); 
                $imageFileType = $request->weddingphoto->extension();
                $imageFilesize = $request->weddingphoto->getSize();
                $imageName = time().'.'.$imageFileType; 
              
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                }elseif($imageFilesize > 4000000) {
                    return redirect()->back()->with('message','your file size is more than 4MB.');
                }else{
                    $imageManager = new ImageManager(new Driver());
                    $thumbImage = $imageManager->read($file);

                    $resizedImage = $thumbImage->resize(1660, 1100)->toJpeg(90);
                    Storage::disk('public')->put('successStory/' . $imageName, $resizedImage);
                    $data->weddingphoto = $imageName;
                }
            }
        }
        $data->bridename = $request->bridename;
        $data->brideid = $request->brideid;
        $data->groomname = $request->groomname;
        $data->groomid = $request->groomid;
        $data->marriagedate = $request->marriagedate;
        $data->engagement_date = $request->engagement_date;
        $data->successmessage = $request->successmessage;
        $data->save();
        return redirect()->route('admin.successStoryList')->with('message', 'Success story updated successfully.');
    }
}
