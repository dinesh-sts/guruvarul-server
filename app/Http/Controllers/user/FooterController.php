<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FooterController extends Controller
{
    public function cmspage(Request $request,$slug)
    {
        $page = CmsPage::where('page_name',$slug)->where('status','APPROVED')->first();
        
        if(Auth::guard('user')->check()){
            return view('user.footer.cmsUser',compact('page'));
        }else{
            return view('user.footer.cms',compact('page'));
        }
        
    }
}
