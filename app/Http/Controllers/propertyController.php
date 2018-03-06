<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Hash;
use App\Models\Appraiser;
use App\Models\Appraisal;
use App\Models\Property;
use App\Models\PropertyLocation;
use App\Models\Seller;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;
use App\Models\Barangay;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class propertyController extends Controller
{
    public function index(){
    	$properties = Property::where('ind_deleted', 0)
            ->where('id_seller',Auth::user()->seller->id_seller)
            ->orderBy('property_name', 'asc')
            ->get();
        $regions = Region::where('ind_deleted',0)->orderBy('region_code')->get();
        $provinces = Province::where('ind_deleted',0)->where('id_region',$regions->first()->id_region)->orderBy('province_code')->get();
        $cities = City::where('ind_deleted',0)->where('id_province',$provinces->first()->id_province)->orderBy('city_code')->get();
        $barangays = Barangay::where('ind_deleted',0)->where('id_city',$cities->first()->id_city)->orderBy('barangay_code')->get();
        $appraisers = Appraiser::all();
        $UpdateRegions = Region::where('ind_deleted',0)->orderBy('region_code')->get();
        $UpdateProvinces = Province::where('ind_deleted',0)->orderBy('province_code')->get();
        $UpdateCities = City::where('ind_deleted',0)->orderBy('city_code')->get();
        $UpdateBarangays = Barangay::where('ind_deleted',0)->orderBy('barangay_code')->get();
        return view('seller.my_properties', ['properties'=>$properties,'regions'=>$regions,'provinces'=>$provinces,'cities'=>$cities,'barangays'=>$barangays,'appraisers' => $appraisers,
        'UpdateRegions'=>$UpdateRegions,'UpdateProvinces'=>$UpdateProvinces,'UpdateCities'=>$UpdateCities,'UpdateBarangays'=>$UpdateBarangays]);
    }


    public function show($id){
        $property = Property::find($id);
        $seller = Seller::where('id_seller', $property->id_seller);
        if (!is_null($property)){
            return view('seller.show', ['property' => $property, 'seller' => $seller]);
        }else{
            return view('errors.404');
        }  
    }

    public function get_property_details(Request $request){
        $property = Property::find($request->propertyPrimaryKey);
        $propertyLocation = PropertyLocation::find($request->propertyLocation);
        $barangay = Barangay::find($propertyLocation->id_barangay);
        $city = City::find($barangay->id_city);
        $province = Province::find($city->id_province);
        $UpdateRegions = Region::where('ind_deleted',0)->orderBy('region_code')->get();
        $UpdateProvinces = Province::where('ind_deleted',0)->orderBy('province_code')->get();
        $UpdateCities = City::where('ind_deleted',0)->orderBy('city_code')->get();
        $UpdateBarangays = Barangay::where('ind_deleted',0)->orderBy('barangay_code')->get();
        
        return response()->json(['property'=>$property, 'propertyLocation'=>$propertyLocation, 'province'=>$province, 'city'=>$city, "barangay"=>$barangay,
        'UpdateRegions'=>$UpdateRegions,'UpdateProvinces'=>$UpdateProvinces,'UpdateCities'=>$UpdateCities,'UpdateBarangays'=>$UpdateBarangays]);
    }

    public function getPropertyData(){
        $properties = Property::where('ind_deleted', 0)
            ->where('id_seller',Auth::user()->seller->id_seller)
            ->orderBy('property_name', 'asc')
            ->get();
        return $properties;
    } 

    public function filter(Request $request){
    	$properties = Property::where('ind_deleted', $request->selFilterValue)
            ->orderBy('property', 'asc')
            ->get();
        if($request->selFilterValue){
        	return view('seller.Table.propertyTable', ['properties' => $properties]);
        } else {
        	return view('seller.Table.propertyTable', ['properties' => $properties]);
        }
    }

    public function suspend(Request $request){
    	$property = Property::find($request->propertyPrimaryKey);
        if (!is_null($property)){
            $property->ind_deleted = 1;
            $property->delete_date = Carbon\Carbon::now();
            $property->save();
            $propertiesNewDataSet = $this->getPropertyData();
            return view('seller.Table.propertyTable', ['properties' => $propertiesNewDataSet]);
        }else{
            return "error";	
        }
    }


    public function restore(Request $request){
    	$property = Property::find($request->strPrimaryKey);
        if (!is_null($property)){
            $property->ind_deleted = 0;
            $property->update_date = Carbon\Carbon::now();
            $property->save();
            $propertiesNewDataSet = $this->getPropertyData();
            return view('seller.Table.propertyTable', ['properties' => $propertiesNewDataSet]);
        }else{
            return "error";	
        }
    }

    public function create(Request $request){
    	try{
            DB::beginTransaction();  
            
            $property = new Property;
            $seller = new Seller;
            $region = new Region;
            $province = new Province;
            $city = new City;
            $barangay = new Barangay;
            $propertyLocation = new PropertyLocation;
            
            $id_user = Auth::user()->id_user;
            $seller = Seller::where('id_user', '=' ,$id_user)->get()->first();

            $barangay = Barangay::find($request->intBarangay);
            $city = City::find($request->intCity);
            $province = Province::find($request->intProvince);
            $region = Region::find($request->intRegion);
            
            $propertyLocation->address   = $request->strPropertyLocation . ' ' . $barangay->barangay_description . ' ' . $city->city_description . ' ' . $province->province_description . ' ' . $region->region_description;
            $propertyLocation->id_barangay   = $request->intBarangay;
            $propertyLocation->save();

            $property->property_name 	    = $request->strPropertyName;
            $property->id_property_location = $propertyLocation->id_property_location;
            $property->id_seller 	        = $seller->id_seller;
            $property->property_type 	    = $request->intPropertyType;
            $property->property_status      = 0;
            $property->tct_number 	        = $request->strTCTNumber;
            $property->lot_area 	        = str_replace(",","",$request->dblLotArea);
            $property->ind_deleted = 0;
            // $property->effective_age 	    = $request->intEffectiveAge;
            $property->save();

            $propertiesNewDataSet = $this->getPropertyData();
            DB::commit();
            return view('seller.Table.propertyTable', ['properties' => $propertiesNewDataSet]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        return $e->getMessage(); 
            //for debugging
	        //return "error";
        }
    }

    public function request_appraisal(Request $request){
        try{
            DB::beginTransaction();  
            $appraisal = new Appraisal;

            $appraisal->id_property         = $request->intPropertyId;
            $appraisal->id_appraiser        = $request->intAppraiserId;
            $appraisal->remarks             = $request->strRemarks;
            $appraisal->appraisal_status    = 1;
            $appraisal->save();
            $property = Property::findOrFail($request->intPropertyId);
            $property->property_status = 1;
            $property->save();
            
            $propertiesNewDataSet = $this->getPropertyData();
            DB::commit();
            return view('seller.Table.propertyTable', ['properties' => $propertiesNewDataSet]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        return $e->getMessage(); 
            //for debugging
	        //return "error";
        }
    }

    public function update(Request $request){
        try{
            DB::beginTransaction(); 
            $property = Property::find($request->propertyId);
            $propertyLocation = PropertyLocation::find($property->id_property_location);

 
            if (!is_null($property)){

                if($propertyLocation->id_barangay != $request->intBarangay || $propertyLocation->address != $request->strPropertyLocation){
                    $region = new Region;
                    $province = new Province;
                    $city = new City;
                    $barangay = new Barangay;
                    
                    $barangay = Barangay::find($request->intBarangay);
                    $city = City::find($request->intCity);
                    $province = Province::find($request->intProvince);
                    $region = Region::find($request->intRegion);
                    
                    $propertyLocation->address       = $request->strPropertyLocation . ' ' . $barangay->barangay_description . ' ' . $city->city_description . ' ' . $province->province_description . ' ' . $region->region_description;
                    $propertyLocation->id_barangay   = $request->intBarangay;
                    $propertyLocation->update_date           = Carbon\Carbon::now();
                    $propertyLocation->save();

                }
                
                $property->property_name 	    = $request->strPropertyName;
                $property->property_type 	    = $request->intPropertyType;
                $property->tct_number 	        = $request->strTCTNumber;
                $property->lot_area 	        = str_replace(",","",$request->dblLotArea);
                $property->update_date          = Carbon\Carbon::now();
                $property->save();

                $propertiesNewDataSet = $this->getPropertyData();
                DB::commit();
                return view('seller.Table.propertyTable', ['properties' => $propertiesNewDataSet]);
            }else{
                return "error";	
            }
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); 
            //for debugging
	        return "error";
        }
    }

}
