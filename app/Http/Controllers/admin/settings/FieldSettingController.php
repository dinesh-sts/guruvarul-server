<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FieldSetting;

class FieldSettingController extends Controller{

    public function fieldSettings(){
        $fieldsetting = FieldSetting::first();
        return view('admin.settings.fieldsetting',compact('fieldsetting'));
    }

    public function fieldSettingsUpdate(Request $request){
        $data = FieldSetting::findOrFail(1);

        if ($request->church_name == "on") {
            $data->church_name = "Yes";
        }else{
            $data->church_name = "No"; 
        }
        if ($request->denomination == "on") {
            $data->denomination = "Yes";
        }else{
            $data->denomination = "No"; 
        }
        if ($request->baptism == "on") {
            $data->baptism = "Yes";
        }else{
            $data->baptism = "No"; 
        }
        if ($request->born_again == "on") {
            $data->born_again = "Yes";
        }else{
            $data->born_again = "No"; 
        }

        if ($request->sub_caste == "on") {
            $data->sub_caste = "Yes";
        }else{
            $data->sub_caste = "No"; 
        }
        if ($request->gotra == "on") {
            $data->gotra = "Yes";
        }else{
            $data->gotra = "No"; 
        }
        if ($request->will_to_marry == "on") {
            $data->will_to_marry = "Yes";
        }else{
            $data->will_to_marry = "No"; 
        }
        if ($request->additional_degree == "on") {
            $data->additional_degree = "Yes";
        }else{
            $data->additional_degree = "No"; 
        }
        if ($request->company_name == "on") {
            $data->company_name = "Yes";
        }else{
            $data->company_name = "No"; 
        }
        if ($request->no_of_married_sister == "on") {
            $data->no_of_married_sister = "Yes";
        }else{
            $data->no_of_married_sister = "No"; 
        }
        if ($request->no_of_sister == "on") {
            $data->no_of_sister = "Yes";
        }else{
            $data->no_of_sister = "No"; 
        }
        if ($request->no_of_married_brother == "on") {
            $data->no_of_married_brother = "Yes";
        }else{
            $data->no_of_married_brother = "No"; 
        }
        if ($request->no_of_brother == "on") {
            $data->no_of_brother = "Yes";
        }else{
            $data->no_of_brother = "No"; 
        }
        if ($request->mother_occupation == "on") {
            $data->mother_occupation = "Yes";
        }else{
            $data->mother_occupation = "No"; 
        }
        if ($request->mother_name == "on") {
            $data->mother_name = "Yes";
        }else{
            $data->mother_name = "No"; 
        }
        if ($request->father_occupation == "on") {
            $data->father_occupation = "Yes";
        }else{
            $data->father_occupation = "No"; 
        }
        if ($request->father_name == "on") {
            $data->father_name = "Yes";
        }else{
            $data->father_name = "No"; 
        }
        if ($request->family_value == "on") {
            $data->family_value = "Yes";
        }else{
            $data->family_value = "No"; 
        }
        if ($request->family_type == "on") {
            $data->family_type = "Yes";
        }else{
            $data->family_type = "No"; 
        }
        if ($request->family_status == "on") {
            $data->family_status = "Yes";
        }else{
            $data->family_status = "No"; 
        }
        if ($request->annual_income == "on") {
            $data->annual_income = "Yes";
        }else{
            $data->annual_income = "No"; 
        }
        if ($request->designation == "on") {
            $data->designation = "Yes";
        }else{
            $data->designation = "No"; 
        }
        if ($request->maternal_details == "on") {
            $data->maternal_details = "Yes";
        }else{
            $data->maternal_details = "No"; 
        }
        if ($request->paternal_details == "on") {
            $data->paternal_details = "Yes";
        }else{
            $data->paternal_details = "No"; 
        }
        if ($request->profile_text == "on") {
            $data->profile_text = "Yes";
        }else{
            $data->profile_text = "No"; 
        }
        if ($request->address == "on") {
            $data->address = "Yes";
        }else{
            $data->address = "No"; 
        }
        if ($request->smoke == "on") {
            $data->smoke = "Yes";
        }else{
            $data->smoke = "No"; 
        }
        if ($request->drink == "on") {
            $data->drink = "Yes";
        }else{
            $data->drink = "No"; 
        }
        if ($request->diet == "on") {
            $data->diet = "Yes";
        }else{
            $data->diet = "No"; 
        }
        if ($request->complexion == "on") {
            $data->complexion = "Yes";
        }else{
            $data->complexion = "No"; 
        }
        if ($request->height == "on") {
            $data->height = "Yes";
        }else{
            $data->height = "No"; 
        }
        if ($request->body_type == "on") {
            $data->body_type = "Yes";
        }else{
            $data->body_type = "No"; 
        }
        if ($request->weight == "on") {
            $data->weight = "Yes";
        }else{
            $data->weight = "No"; 
        }
        if ($request->physical_status == "on") {
            $data->physical_status = "Yes";
        }else{
            $data->physical_status = "No"; 
        }
        if ($request->b_group == "on") {
            $data->b_group = "Yes";
        }else{
            $data->b_group = "No"; 
        }
        if ($request->manglik == "on") {
            $data->manglik = "Yes";
        }else{
            $data->manglik = "No"; 
        }
        if ($request->dosh == "on") {
            $data->dosh = "Yes";
        }else{
            $data->dosh = "No"; 
        }
        if ($request->rasi == "on") {
            $data->rasi = "Yes";
        }else{
            $data->rasi = "No"; 
        }
        if ($request->star == "on") {
            $data->star = "Yes";
        }else{
            $data->star = "No"; 
        }
        if ($request->birthtime == "on") {
            $data->birthtime = "Yes";
        }else{
            $data->birthtime = "No"; 
        }
        if ($request->birthplace == "on") {
            $data->birthplace = "Yes";
        }else{
            $data->birthplace = "No"; 
        }
        if ($request->part_complexation == "on") {
            $data->part_complexation = "Yes";
        }else{
            $data->part_complexation = "No"; 
        }
        if ($request->part_bodytype == "on") {
            $data->part_bodytype = "No";
        }else{
            $data->part_bodytype = "Yes"; 
        }
        if ($request->part_physical_status == "on") {
            $data->part_physical_status = "Yes";
        }else{
            $data->part_physical_status = "No"; 
        }
        if ($request->part_diet == "on") {
            $data->part_diet = "Yes";
        }else{
            $data->part_diet = "No"; 
        }
        if ($request->part_smoke == "on") {
            $data->part_smoke = "Yes";
        }else{
            $data->part_smoke = "No"; 
        }
        if ($request->part_drink == "on") {
            $data->part_drink = "Yes";
        }else{
            $data->part_drink = "No"; 
        }
        if ($request->part_annual_income == "on") {
            $data->part_annual_income = "Yes";
        }else{
            $data->part_annual_income = "No"; 
        }
        if ($request->part_star == "on") {
            $data->part_star = "Yes";
        }else{
            $data->part_star = "No"; 
        }
        if ($request->part_rasi == "on") {
            $data->part_rasi = "Yes";
        }else{
            $data->part_rasi = "No"; 
        }
        if ($request->part_manglik == "on") {
            $data->part_manglik = "Yes";
        }else{
            $data->part_manglik = "No"; 
        }
        if ($request->part_dosh == "on") {
            $data->part_dosh = "Yes";
        }else{
            $data->part_dosh = "No"; 
        }
        if ($request->part_state == "on") {
            $data->part_state = "Yes";
        }else{
            $data->part_state = "No"; 
        }
        if ($request->part_city == "on") {
            $data->part_city = "Yes";
        }else{
            $data->part_city = "No"; 
        }
        if ($request->part_expect == "on") {
            $data->part_expect = "Yes";
        }else{
            $data->part_expect = "No"; 
        }
        $data->save();
           
        return redirect()->route('admin.fieldSettings')->with('message', 'Data Updated Sucessfully');
    }
}
