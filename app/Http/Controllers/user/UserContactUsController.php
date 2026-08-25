<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\contactusRequest;
use App\Models\CmsPage;
use App\Models\Contactus;
use Illuminate\Support\Carbon;

class UserContactUsController extends Controller
{
    public function contactUs()
    {
        $cms = CmsPage::where('page_name','contact-us')->first();
        return view('user.contactus',compact('cms'));
    }

    public function contactUsPost(contactusRequest $request)
    {
        $data = new Contactus();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->subject = $request->subject;
        $data->description = $request->description;
        $data->date = Carbon::now();
        $data->save();
        return redirect()->back()->with('message',"Contact request sent.");
    }
}