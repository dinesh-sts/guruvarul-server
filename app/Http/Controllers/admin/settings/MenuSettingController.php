<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\MenuSetting;
use Illuminate\Http\Request;

class MenuSettingController extends Controller{

    public function menuSettings(){
        $menusetting = MenuSetting::first();
        return view('admin.settings.menusetting',compact('menusetting'));
       
    }

    public function menuSettingsUpdate(Request $request){
        //dd($request->menu_search);
        $data = MenuSetting::findOrFail(1);
        
        if ($request->menu_search == "on" ) {
            $data->menu_search = "APPROVED";
        }else{
            $data->menu_search = "UNAPPROVED"; 
        }
        if ($request->menu_success == "on") {
            $data->menu_success = "APPROVED";
        }else{
            $data->menu_success = "UNAPPROVED"; 
        }
        if ($request->menu_membership == "on") {
            $data->menu_membership = "APPROVED";
        }else{
            $data->menu_membership = "UNAPPROVED"; 
        }
        if ($request->menu_contact == "on") {
            $data->menu_contact = "APPROVED";
        }else{
            $data->menu_contact = "UNAPPROVED"; 
        }
        if ($request->menu_login == "on") {
            $data->menu_login = "APPROVED";
        }else{
            $data->menu_login = "UNAPPROVED"; 
        }
        if ($request->menu_signup == "on") {
            $data->menu_signup = "APPROVED";
        }else{
            $data->menu_signup = "UNAPPROVED"; 
        }
        if ($request->footer_contact == "on") {
            $data->footer_contact = "APPROVED";
        }else{
            $data->footer_contact = "UNAPPROVED"; 
        }
        if ($request->footer_faq == "on") {
            $data->footer_faq = "APPROVED";
        }else{
            $data->footer_faq = "UNAPPROVED"; 
        }
        if ($request->footer_refund == "on") {
            $data->footer_refund = "APPROVED";
        }else{
            $data->footer_refund = "UNAPPROVED"; 
        }
        if ($request->footer_terms == "on") {
            $data->footer_terms = "APPROVED";
        }else{
            $data->footer_terms = "UNAPPROVED"; 
        }
        if ($request->footer_policy == "on") {
            $data->footer_policy = "APPROVED";
        }else{
            $data->footer_policy = "UNAPPROVED"; 
        }
        if ($request->footer_report == "on") {
            $data->footer_report = "APPROVED";
        }else{
            $data->footer_report = "UNAPPROVED"; 
        }
        if ($request->footer_login == "on") {
            $data->footer_login = "APPROVED";
        }else{
            $data->footer_login = "UNAPPROVED"; 
        }
        if ($request->footer_register == "on") {
            $data->footer_register = "APPROVED";
        }else{
            $data->footer_register = "UNAPPROVED"; 
        }
        if ($request->footer_membership == "on") {
            $data->footer_membership = "APPROVED";
        }else{
            $data->footer_membership = "UNAPPROVED"; 
        }
        if ($request->footer_success == "on") {
            $data->footer_success = "APPROVED";
        }else{
            $data->footer_success = "UNAPPROVED"; 
        }
        if ($request->footer_about == "on") {
            $data->footer_about = "APPROVED";
        }else{
            $data->footer_about = "UNAPPROVED"; 
        }
        if ($request->footer_search == "on") {
            $data->footer_search = "APPROVED";
        }else{
            $data->footer_search = "UNAPPROVED"; 
        }
        if ($request->footer_about_short == "on") {
            $data->footer_about_short = "APPROVED";
        }else{
            $data->footer_about_short = "UNAPPROVED"; 
        }
        $data->save();
       
        return redirect()->route('admin.menuSettings')->with('message', 'Data Updated Sucessfully');
    }
}
