<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon;
use Hash;
use App\User;
use App\Models\Appraiser;
use App\Models\Appraisal;
use App\Models\AppraisalDetails;
use App\Models\AppraiseProperty;
use App\Models\AppraisePropertyPicture;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;
use App\Models\Barangay;
use App\Models\HouseModel;
use App\Models\Property;
use App\Models\Comparable;
use App\Models\PropertyLocation;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class appraiserController extends Controller
{
    public function index(){
    	$appraisers = Appraiser::where('ind_deleted', 0)
            ->orderBy('first_name', 'asc')
            ->get();
        return view('appraiser.index', ['appraisers' => $appraisers]);
    }

    public function show($id){
        $appraiser = Appraiser::find($id);
        $user = User::where('id_user', $appraiser->id_user);
        if (!is_null($appraiser)){
            return view('appraiser.show', ['appraiser' => $appraiser, 'user' => $user]);
        }else{
            return view('errors.404');
        }  
    }

    public function getAppraiserData(){
    	$appraisers = Appraiser::where('ind_deleted', 0)
            ->orderBy('first_name', 'asc')
            ->get();
        return $appraisers;
    }

    public function filter(Request $request){
    	$appraisers = Appraiser::where('ind_deleted', $request->selFilterValue)
            ->orderBy('first_name', 'asc')
            ->get();
        if($request->selFilterValue){
        	return view('appraiser.Table.appraiserSuspendTable', ['appraisers' => $appraisers]);
        } else {
        	return view('appraiser.Table.appraiserTable', ['appraisers' => $appraisers]);
        }
    }

    public function suspend(Request $request){
    	$appraiser = Appraiser::find($request->strPrimaryKey);
        if (!is_null($appraiser)){
            $appraiser->ind_deleted = 1;
            $appraiser->update_date = Carbon\Carbon::now();
            $appraiser->save();
            $appraisersNewDataSet = $this->getAppraiserData();
            return view('appraiser.Table.appraiserTable', ['appraisers' => $appraisersNewDataSet]);
        }else{
            return "error";	
        }
    }


    public function restore(Request $request){
    	$appraiser = Appraiser::find($request->strPrimaryKey);
        if (!is_null($appraiser)){
            $appraiser->ind_deleted = 0;
            $appraiser->update_date = Carbon\Carbon::now();
            $appraiser->save();
            $appraisersNewDataSet = $this->getAppraiserData();
            return view('appraiser.Table.appraiserTable', ['appraisers' => $appraisersNewDataSet]);
        }else{
            return "error";	
        }
    }

    public function create(Request $request){
    	try{
            DB::beginTransaction();  
            $file = $request->inputPicture;
            $picture = "";
            if($file == '' || $file == null){
                $picture = "assets/image/avatar/AdminAvatar.jpg";
            }else{
                $date = date("Ymdhis");
                $extension = $request->inputPicture->getClientOriginalExtension();
                $picture = "assets/image/avatar/".$date.'.'.$extension;
                $request->inputPicture->move("assets/image/avatar",$picture);    
            }
            $appraiser = new Appraiser;
            $user = new User;
            
        	$user->email 			= $request->strAppraiserEmail;
        	$user->remember_token 	= str_random(60);
            $user->password 	    = Hash::make($request->strPassword);
            $user->user_type 	    = 1;
            
            $user->save();
            
            $appraiser->first_name 	= $request->strFirstname;
            $appraiser->middle_name = $request->strMiddlename;
            $appraiser->last_name 	= $request->strLastname;
            $appraiser->contact_num = $request->inputAppraiserContact;
            $appraiser->id_user     = $user->id_user;
            $appraiser->profile_image = $picture;
            $appraiser->save();

            $appraisersNewDataSet = $this->getAppraiserData();
            DB::commit();
            return view('appraiser.Table.appraiserTable', ['appraisers' => $appraisersNewDataSet]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function update(Request $request){
        $appraiser = Appraiser::find($request->strPrimaryKey);

        if (!is_null($appraiser)){
            $appraiser->first_name = $request->strFirstname;
            $appraiser->middle_name = $request->strMiddlename;
            $appraiser->last_name = $request->strLastname;
            $appraiser->update_date = Carbon\Carbon::now();
            $appraiser->save();
            $appraisersNewDataSet = $this->getAppraiserData();
            return view('appraiser.Table.appraiserTable', ['appraisers' => $appraisersNewDataSet]);
        }else{
            return "error";	
        }
    }

	public function resetpassword(Request $request){
        $user = User::find($request->intUserID);
        if (!is_null($user)){
            $user->password = Hash::make($request->strPassword);
            $user->save();
            return "success";
        }else{
            return "error";	
        }
    }

    public function load_request_appraisal(){
    	$appraisals = Appraisal::where('ind_deleted', 0)->where('id_appraiser', Auth::user()->appraiser->id_appraiser) 
            ->orderBy('id_appraisal', 'asc')
            ->get();
        return view('appraiser.request_appraisal', ['appraisals' => $appraisals]);
    }

    public function load_appraisal($id){
        $appraisal = Appraisal::find($id);
        $regions = Region::where('ind_deleted',0)->orderBy('region_code')->get();
        $provinces = Province::where('ind_deleted',0)->where('id_region',$regions->first()->id_region)->orderBy('province_code')->get();
        $cities = City::where('ind_deleted',0)->where('id_province',$provinces->first()->id_province)->orderBy('city_code')->get();
        $barangays = Barangay::where('ind_deleted',0)->where('id_city',$cities->first()->id_city)->orderBy('barangay_code')->get();
        $house_models = HouseModel::where('ind_deleted',0)->orderBy('house_model')->get();
        if (!is_null($appraisal)){
            return view('appraiser.appraise', compact('appraisal','regions','provinces','cities','barangays','house_models'));
        }else{
            return view('errors.404');
        }
    }

    public function appraise(Request $request){
        try{
            DB::beginTransaction();
            $appraiser = new Appraiser;
            $appraisal = new Appraisal;
            $appraisaldetails = new AppraisalDetails;
            $comparable = new Comparable;
            $appraiseproperty =  new AppraiseProperty;
            $property = new Property;
            $region = new Region;
            $province = new Province;
            $city = new City;
            $barangay = new Barangay;
            $propertyLocation = new PropertyLocation;

            //$id_user = Auth::user()->id_user;
            //$appraiser = Appraiser::where('id_user', '=' ,$id_user)->get()->first();

            $barangay = Barangay::find($request->prpty1_barangay);
            $city = City::find($request->prpty1_city);
            $province = Province::find($request->prpty1_province);
            $region = Region::find($request->prpty1_region);
            
            $propertyLocation = new PropertyLocation;
            $propertyLocation->address          = $request->prpty1_property_location . ' ' . $barangay->barangay_description . ' ' . $city->city_description . ' ' . $province->province_description . ' ' . $region->region_description;
            $propertyLocation->id_barangay      = $request->prpty1_barangay;
            $propertyLocation->save();
            
            $comparable = new Comparable;
            $comparable->property_name 	        = $request->prpty1_property_name;
            $comparable->id_property_location   = $propertyLocation->id_property_location;
            $comparable->property_type          = $request->subj_property_type;
            $comparable->lot_value              = $request->prpty1_lot_value;
            $comparable->save();

            $appraisaldetails = new AppraisalDetails;
            $appraisaldetails->id_appraisal                = $request->subj_id_appraisal;
            $appraisaldetails->id_comparable_property      = $comparable->id_comparable_property;
            $appraisaldetails->save();
            
            $barangay = Barangay::find($request->prpty2_barangay);
            $city = City::find($request->prpty2_city);
            $province = Province::find($request->prpty2_province);
            $region = Region::find($request->prpty2_region);
            
            $propertyLocation = new PropertyLocation;
            $propertyLocation->address          = $request->prpty2_property_location . ' ' . $barangay->barangay_description . ' ' . $city->city_description . ' ' . $province->province_description . ' ' . $region->region_description;
            $propertyLocation->id_barangay      = $request->prpty2_barangay;
            $propertyLocation->save();
            
            $comparable = new Comparable;
            $comparable->property_name 	        = $request->prpty2_property_name;
            $comparable->id_property_location   = $propertyLocation->id_property_location;
            $comparable->property_type          = $request->subj_property_type;
            $comparable->lot_value              = $request->prpty2_lot_value;
            $comparable->save();

            $appraisaldetails = new AppraisalDetails;
            $appraisaldetails->id_appraisal                = $request->subj_id_appraisal;
            $appraisaldetails->id_comparable_property      = $comparable->id_comparable_property;
            $appraisaldetails->save();

        
            $barangay = Barangay::find($request->prpty3_barangay);
            $city = City::find($request->prpty3_city);
            $province = Province::find($request->prpty3_province);
            $region = Region::find($request->prpty3_region);
            
            $propertyLocation = new PropertyLocation;
            $propertyLocation->address          = $request->prpty3_property_location . ' ' . $barangay->barangay_description . ' ' . $city->city_description . ' ' . $province->province_description . ' ' . $region->region_description;
            $propertyLocation->id_barangay      = $request->prpty3_barangay;
            $propertyLocation->save();  
            
            $comparable = new Comparable;
            $comparable->property_name 	        = $request->prpty3_property_name;
            $comparable->id_property_location   = $propertyLocation->id_property_location;
            $comparable->property_type          = $request->subj_property_type;
            $comparable->lot_value              = $request->prpty3_lot_value;
            $comparable->save();

            $appraisaldetails = new AppraisalDetails;
            $appraisaldetails->id_appraisal                = $request->subj_id_appraisal;
            $appraisaldetails->id_comparable_property      = $comparable->id_comparable_property;
            $appraisaldetails->save();

            $appraiseproperty = new AppraiseProperty;
            $appraiseproperty->id_appraisal         = $request->subj_id_appraisal;
            $appraiseproperty->inspection_date      = $request->subj_dtInspection;
            $appraiseproperty->appraisal_date   	= $request->subj_dtAppraisal;
            $appraiseproperty->registry_of_deeds    = $request->subj_reg_deeds;
            $appraiseproperty->id_house_model       = $request->subj_house_model;
            $appraiseproperty->number_of_storeys 	= $request->subj_num_storey;
            $appraiseproperty->effective_age        = $request->subj_effective_age;
            $appraiseproperty->total_ecolife        = $request->subj_total_ecolife;
            $appraiseproperty->remaining_ecolife    = $request->subj_remaining_ecolife;
            $appraiseproperty->remarks              = $request->subj_remarks;
            $appraiseproperty->house_value          = $request->house_value;
            $appraiseproperty->ave_lot_value        = $request->average_lot_value;
            $appraiseproperty->total_lot_value      = $request->appraisal_total_lot_value;
            $appraiseproperty->total_house_value 	= $request->appraisal_total_house_value;
            $appraiseproperty->total_property_value = $request->appraisal_total_property_value;
            $appraiseproperty->save();
            
            $appraisal= Appraisal::find($request->subj_id_appraisal);
            $appraisal->update_date = Carbon\Carbon::now();
            $appraisal->appraisal_status = 2;
            $appraisal->save();

            $property= Property::find($appraisal->id_property);
            $property->update_date = Carbon\Carbon::now();
            $property->property_status = 2;
            $property->save();

            //$propertiesNewDataSet = $this->getPropertyData();
            DB::commit();
            return view('appraiser.appraised', ['appraiseproperty' => $appraiseproperty]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        return $e->getMessage(); 
            //for debugging
	        //return "error";
        }
    }

    public function viewAppraisal(Request $request){
        $appraiseproperty = AppraiseProperty::where('id_appraisal',$request->id)->first();
        return view('appraiser.appraised', ['appraiseproperty' => $appraiseproperty]);
    }
}
