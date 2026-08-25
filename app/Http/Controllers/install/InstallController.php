<?php

namespace App\Http\Controllers\install;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function step0(){
        return view('install.step0');
    }

    public function step1(){
        $permission['curl_enabled']           = function_exists('curl_version');
        $permission['db_file_write_perm']     = is_writable(base_path('.env'));
        $permission['routes_file_write_perm'] = is_writable(base_path('bootstrap/app.php'));
        return view('install.step1', compact('permission'));
    }
    public function step2(){
        return view('install.step2');
    }

    public function purchase_code(Request $request) {
        return redirect('step3');
    }

    public function step3($error = "") {
        if($error == ""){
            return view('install.step3');
        }else {
            return view('install.step3', compact('error'));
        }
    }
    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "") {
        if(@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        }else {
            return false;
        }
    }
    public function writeEnvironmentFile($type, $val) {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            file_put_contents($path, str_replace(
                $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
            ));
        }
    }
    public function database_installation(Request $request) {

        if(self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {
            $path = base_path('.env');
            if (file_exists($path)) {
                foreach ($request->types as $type) {
                    $this->writeEnvironmentFile($type, $request[$type]);
                }
                return redirect('step4');
            }else {
                return redirect('step3');
            }
        }else {
            return redirect('step3/database_error');
        }
    }
    
    public function step4() {
        return view('install.step4');
    }
    
    public function import_sql() {
        $sql_path = base_path('premium_3.sql');
        DB::unprepared(file_get_contents($sql_path));
        return redirect('step5');
    }

    public function step5() {
        return view('install.step5');
    }
    public function step6() {
        return view('install.step6');
    }

    public function system_settings(Request $request) {
        
        $rules = $request->validate([
            'admin_username' => 'required|alpha_dash',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:8',
        ]);
        
        //$this->writeEnvironmentFile('APP_NAME', $request->system_name);

        $admin = AdminUser::where('id','1')->first();

        $admin->email = $request->admin_email;
        $admin->uname = $request->admin_username;
        $admin->role = 'Admin';
        $admin->status = '1';
        $admin->password = Hash::make($request->admin_password);
        $admin->save();

        $previousRouteServiceProvier = base_path('bootstrap/app.php');
        $newRouteServiceProvier      = base_path('bootstrap/app.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
    
        return view('install.step6');
        
        
    }

}
