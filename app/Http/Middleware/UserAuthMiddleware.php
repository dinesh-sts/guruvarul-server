<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use App\Models\Register;
use App\Models\SiteConfig;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $site_configvarify = SiteConfig::first();
        if(Auth::guard('user')->user() != null)
        {
            if(Auth::guard('user')->user()->status == "Inactive"){   
                Auth::guard('user')->logout();
                return redirect()->route('user.login')->with('message', 'Your profile is not verified.');

            }elseif(Auth::guard('user')->user()->mobile_verify == Null){

                Session::put('registerid', Auth::guard('user')->user()->id);
                Auth::guard('user')->logout();
                return redirect()->route('user.mobileVerify')->with('message', 'Your profile is not verified.');

            }elseif(Auth::guard('user')->user()->status == "Suspended"){

                Auth::guard('user')->logout();
                return redirect()->route('user.login')->with('message', 'Your profile is deleted.');

            }else{
                
                $user = Auth::guard('user')->user();
                $payment_exp = Payment::where('pmatri_id',$user->matri_id)->OrderBy('created_at', 'desc')->first();
                $today = \Carbon\Carbon::now()->format('d-m-Y');

                $data = Register::find(Auth::guard('user')->user()->id);
                $data->online_time = \Carbon\Carbon::now();
                $data->save();
                
                if($payment_exp != null)
                {
                    $date = \Carbon\Carbon::createFromFormat('d-m-y', $payment_exp->exp_date)->format('d-m-Y');
                    $today = strtotime(date($today));
                    $date = strtotime(date($date));
                    if($date >= $today)
                    {
                        return $next($request);
                    }else{
                        $data = Register::find($user->id);
                        $data->status = "Active";
                        $data->save();
                        return $next($request);
                    }
                }else{
                    $data = Register::find(Auth::guard('user')->user()->id);
                    $data->online_time = \Carbon\Carbon::now();
                    $data->save();
                    return $next($request);
                }
            }
        } else{
            return redirect()->route('user.login')->with('message', 'Unauthorize. Please login.');
        }
    }
}


