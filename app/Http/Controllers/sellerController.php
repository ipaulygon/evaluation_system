<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
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
        $sellers = Seller::where('ind_deleted',0)
            ->orderBy('first_name','asc')
            ->get();
        return view('seller.index',compact('sellers'));
    }

    public function filter(Request $request){
    	$sellers = Seller::where('ind_deleted', $request->selFilterValue)
            ->orderBy('first_name', 'asc')
            ->get();
        if($request->selFilterValue){
        	return view('seller.Table.sellerSuspendTable', ['sellers' => $sellers]);
        } else {
        	return view('seller.Table.sellerTable', ['sellers' => $sellers]);
        }
    }

    public function suspend(Request $request){
        try{
            DB::beginTransaction();  
            $seller = Seller::findOrFail($request->strPrimaryKey);
            $seller->ind_deleted = 1;
            $seller->isActive = 0;
            $seller->update_date = Carbon::now();
            $seller->save();
            $sellerNewDataSet = $this->getSellers();
            DB::commit();
            return view('seller.Table.sellerTable', ['sellers' => $sellerNewDataSet]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function restore(Request $request){
        try{
            DB::beginTransaction();  
            $seller = Seller::findOrFail($request->strPrimaryKey);
            $seller->ind_deleted = 0;
            $seller->isActive = 0;            
            $seller->update_date = Carbon::now();
            $seller->save();
            $sellerNewDataSet = $this->getSellers();
            DB::commit();
            return view('seller.Table.sellerTable', ['sellers' => $sellerNewDataSet]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function accept(Request $request){
        try{
            DB::beginTransaction();  
            $seller = Seller::findOrFail($request->strPrimaryKey);
            $seller->isActive = 1;
            $seller->update_date = Carbon::now();
            $seller->save();
            $sellerNewDataSet = $this->getSellers();
            DB::commit();
            return view('seller.Table.sellerTable', ['sellers' => $sellerNewDataSet]);
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function getSellers(){
        return Seller::where('ind_deleted', 0)
            ->orderBy('first_name', 'asc')
            ->get();
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

    public function SoldProperty(Request $request){
        try{
            DB::beginTransaction();  
            $property = Property::findOrFail($request->id);
            $property->property_status = 5;
            $property->save();
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
