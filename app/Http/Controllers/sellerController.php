<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon;
use Hash;
use App\Models\Seller;
use App\Models\Property;
use App\Models\Region;
use App\Models\Province;
use App\SellProperty;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class sellerController extends Controller
{
    public function index(){
    	$properties = Property::where('ind_deleted', 0)
            ->where('id_seller',Auth::user()->seller->id_seller)
            ->orderBy('property_name', 'asc')
            ->get();
        $regions = Region::where('ind_deleted',0)->orderBy('region_code')->get();
        return view('seller.my_properties',compact('properties','regions'));
    }

    public function getProperties(){
        return Property::where('ind_deleted', 0)
            ->where('id_seller',Auth::user()->seller->id_seller)
            ->orderBy('property_name', 'asc')
            ->get();
    }

    public function PublishProperty(Request $request){
        try{
            DB::beginTransaction();  
            $property = Property::findOrFail($request->id);
            $property->property_status = 4;
            $property->save();
            SellProperty::create([
                'id_appraisal' => $request->id,
                'price' => $request->price,
                'remarks' => $request->remarks,
                'counter' => 0
            ]);
            $properties = $this->getProperties();
            DB::commit();
            return view('seller.Table.propertyTable', compact('properties'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }
}
