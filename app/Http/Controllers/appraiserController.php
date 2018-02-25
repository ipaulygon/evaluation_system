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
        $regions = Region::all();
        $house_models = HouseModel::all();
        if (!is_null($appraisal)){
            return view('appraiser.appraise', ['appraisal' => $appraisal, 'regions' => $regions, 'house_models' => $house_models]);
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
            $comparable->inspection_date 	    = $request->prpty1_dtInspection;
            $comparable->appraisal_date 	    = $request->prpty1_dtAppraisal;
            $comparable->registry_of_deeds      = $request->prpty1_reg_deeds;
            $comparable->id_house_model         = $request->prpty1_house_model;
            $comparable->number_of_storeys 	    = $request->prpty1_num_storey;
            $comparable->rental_rate 	        = $request->prpty1_rental_rate;
            $comparable->lot_area               = $request->prpty1_lot_area;
            $comparable->floor_area             = $request->prpty1_floor_area;
            $comparable->effective_age          = $request->prpty1_effective_age;
            $comparable->total_ecolife          = $request->prpty1_total_ecolife;
            $comparable->remaining_ecolife      = $request->prpty1_remaining_ecolife;
            $comparable->remarks                = $request->prpty1_remarks;
            $comparable->lot_value              = $request->prpty1_lot_value;
            $comparable->completion             = $request->prpty1_completion;
            $comparable->house_value 	        = $request->prpty1_house_value;
            $comparable->depreciated_value      = $request->prpty1_depreciated_value;
            $comparable->cost_of_improvement    = $request->prpty1_cost_improvement;
            $comparable->total_value 	        = $request->prpty1_total_value;
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
            $comparable->inspection_date 	    = $request->prpty2_dtInspection;
            $comparable->appraisal_date 	    = $request->prpty2_dtAppraisal;
            $comparable->registry_of_deeds      = $request->prpty2_reg_deeds;
            $comparable->id_house_model         = $request->prpty2_house_model;
            $comparable->number_of_storeys 	    = $request->prpty2_num_storey;
            $comparable->rental_rate 	        = $request->prpty2_rental_rate;
            $comparable->lot_area               = $request->prpty2_lot_area;
            $comparable->floor_area             = $request->prpty2_floor_area;
            $comparable->effective_age          = $request->prpty2_effective_age;
            $comparable->total_ecolife          = $request->prpty2_total_ecolife;
            $comparable->remaining_ecolife      = $request->prpty2_remaining_ecolife;
            $comparable->remarks                = $request->prpty2_remarks;
            $comparable->lot_value              = $request->prpty2_lot_value;
            $comparable->completion             = $request->prpty2_completion;
            $comparable->house_value 	        = $request->prpty2_house_value;
            $comparable->depreciated_value      = $request->prpty2_depreciated_value;
            $comparable->cost_of_improvement    = $request->prpty2_cost_improvement;
            $comparable->total_value 	        = $request->prpty2_total_value;
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
            $comparable->inspection_date 	    = $request->prpty3_dtInspection;
            $comparable->appraisal_date 	    = $request->prpty3_dtAppraisal;
            $comparable->registry_of_deeds      = $request->prpty3_reg_deeds;
            $comparable->id_house_model         = $request->prpty3_house_model;
            $comparable->number_of_storeys 	    = $request->prpty3_num_storey;
            $comparable->rental_rate 	        = $request->prpty3_rental_rate;
            $comparable->lot_area               = $request->prpty3_lot_area;
            $comparable->floor_area             = $request->prpty3_floor_area;
            $comparable->effective_age          = $request->prpty3_effective_age;
            $comparable->total_ecolife          = $request->prpty3_total_ecolife;
            $comparable->remaining_ecolife      = $request->prpty3_remaining_ecolife;
            $comparable->remarks                = $request->prpty3_remarks;
            $comparable->lot_value              = $request->prpty3_lot_value;
            $comparable->completion             = $request->prpty3_completion;
            $comparable->house_value 	        = $request->prpty3_house_value;
            $comparable->depreciated_value      = $request->prpty3_depreciated_value;
            $comparable->cost_of_improvement    = $request->prpty3_cost_improvement;
            $comparable->total_value 	        = $request->prpty3_total_value;
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
            $appraiseproperty->rental_rate 	        = $request->subj_rental_rate;
            $appraiseproperty->lot_area             = $request->subj_lot_area;
            $appraiseproperty->floor_area           = $request->subj_floor_area;
            $appraiseproperty->effective_age        = $request->subj_effective_age;
            $appraiseproperty->total_ecolife        = $request->subj_total_ecolife;
            $appraiseproperty->remaining_ecolife    = $request->subj_remaining_ecolife;
            $appraiseproperty->remarks              = $request->subj_remarks;
            $appraiseproperty->lot_value            = $request->appraisal_lot_value;
            $appraiseproperty->completion           = $request->subj_completion;
            $appraiseproperty->house_value 	        = $request->appraisal_house_value;
            $appraiseproperty->depreciated_value    = $request->appraisal_depreciated_value;
            $appraiseproperty->cost_of_improvement  = $request->appraisal_cost_improvement;
            $appraiseproperty->total_value 	        = $request->appraisal_total_value;
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
            
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        return $e->getMessage(); 
            //for debugging
	        //return "error";
        }
    }

    public function uploadImageAppraiseProperty(Request $request){
        try{
            DB::beginTransaction();  
            if ($request->hasFile('appraisePicture')) {
                $files = $request->file('appraisePicture');
                foreach($files as $file){
                    $date = date("Ymdhis");
                    $extension = $file->getClientOriginalExtension();
                    $picture = "assets/image/appraise/".$date.'.'.$extension;
                    echo $picture;
                    $file->move("assets/image/appraise",$picture); 
                    ///$appraisePropertyPicture = new AppraisePropertyPicture;
                    ///$appraisePropertyPicture->picture_path = $picture;
                    ///$appraisePropertyPicture->save();
                }
            }
            
            DB::commit();
            
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        return $e->getMessage(); 
            //for debugging
	        //return "error";
        }   
    }
}
