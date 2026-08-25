<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use App\Http\Requests\cmsrequest;
use Illuminate\Support\Str;

class CmsPageController extends Controller{

    public function cms(Request $request){
        $filter = $request->input('filter');

        $query = CmsPage::select('id','page_name','cms_title','cms_content','status','page_placement');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $cmspages = $query->orderByDesc('id')->get();
        $cmspagesCount = CmsPage::count();
        $cmspagesApprovedCount =CmsPage::where('status',"APPROVED")->count();
        $cmspagesUnapprovedCount =CmsPage::where('status',"UNAPPROVED")->count();

        return view('admin.cmsPageManagement.cmsList',compact('cmspagesApprovedCount','cmspagesUnapprovedCount','cmspagesCount','cmspages'));
    }

    public function cmsCreate(){
        return view('admin.cmsPageManagement.cmsCreate');
    }

    public function cmsStore(cmsrequest $request){
        $data = new CmsPage();
        $generatedSlug = Str::slug($request->page_name);
        $data->page_name = $generatedSlug;
        $data->page_placement = $request->page_placement;
        $data->cms_title = $request->cms_title;
        $data->cms_content = $request->cms_content;
        $data->status = $request->status;
        $data->save();
        return redirect()->back()->with('message','Data Stored Successfully');
    }

    public function cmsEdit($id){
        $cmspage = CmsPage::findOrFail($id);
        return view('admin.cmsPageManagement.cmsCreate',compact('cmspage'));
    }

    public function cmsUpdate(Request $request,$id){
        $data = CmsPage::findOrFail($id);
        $generatedSlug = Str::slug($request->page_name);
        $data->page_name = $generatedSlug;
        $data->cms_title = $request->cms_title;
        $data->cms_content = $request->cms_content;
        $data->page_placement = $request->page_placement;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('admin.cmsList')->with('message','Data Updated Successfully');
    }

    public function cmsDelete($id){
        $data = CmsPage::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('message','Data Deleted Successfully');
    }

    public function cmsStatus(Request $request){
        $selectedIds = $request->input('selectedreligion');

        if($request->action == "approve"){
            CmsPage::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            CmsPage::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "delete"){
            CmsPage::whereIn('id', $selectedIds)->delete();
            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
