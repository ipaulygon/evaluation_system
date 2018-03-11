<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

use Hash;
use App\User;
use App\Models\Seller;
use App\Models\Property;
use App\Models\Region;
use App\Models\Province;
use App\SellProperty;
use App\Models\AppraisePropertyPicture;
use App\Models\Appraisal;
use App\Models\AppraiseProperty;
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
            $seller->ind_active = 0;
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
            $seller->ind_active = 0;            
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
            $seller = Seller::find($request->strPrimaryKey);
            $seller->ind_active = 1;
            $seller->update_date = Carbon::now();
            $seller->save();
            DB::commit();
            $sellerNewDataSet = $this->getSellers();
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
            $property = Property::findOrFail($request->propertyId);
            $property->property_status = 4;
            $property->save();
            SellProperty::create([
                'id_appraisal' => $request->appraisalId,
                'price' => str_replace(",","",$request->price),
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

    public function UpdateProperty(Request $request){
        try{
            DB::beginTransaction();  
            $sell_property = SellProperty::findOrFail($request->sellPropertyId);
            $sell_property->update([
                'price' => str_replace(",","",$request->price),
                'remarks' => $request->remarks
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

    public function uploadImage(Request $request){
        try{
            DB::beginTransaction();  
            $file = $request->inputPicture;
            $picture = "";
            if($file == '' || $file == null){
                $picture = "assets/image/avatar/AdminAvatar.jpg";
            }else{
                $date = date("Ymdhis");
                $extension = $request->inputPicture->getClientOriginalExtension();
                $picture = "assets/image/appraise/".$date.'.'.$extension;
                $request->inputPicture->move("assets/image/appraise",$picture);    
            }
            $pp = new AppraisePropertyPicture;
            $pp->id_property = $request->propertyId;
            $pp->picture_path = $picture;
            $pp->save();
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function viewProperty(Request $request){
        $property = Property::findOrFail($request->id);
        $appraisals = Appraisal::where('id_property',$request->id)->where('ind_deleted',0)->orderBy('create_date','desc')->get();
        return view('seller.details',compact('property','appraisals'));
    }

    public function removePicture(Request $request){
        try{
            DB::beginTransaction();  
            $image = AppraisePropertyPicture::findOrFail($request->id);
            $image->delete();
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function AppraisedValue(Request $request){
        $property = Property::findOrFail($request->id);
        $appraisal = Appraisal::where('id_property',$request->id)->orderBy('create_date','desc')->first();
        $appraisal_property = AppraiseProperty::where('id_appraisal',$appraisal->id_appraisal)->first();
        return response()->json(["<label>Appraisal Value: PhP ".number_format($appraisal_property->total_property_value,2)."</label>",$appraisal->id_appraisal]);
    }

    public function UpdateValue(Request $request){
        $property = Property::findOrFail($request->id);
        $appraisal = Appraisal::where('id_property',$request->id)->orderBy('create_date','desc')->first();
        $appraisal_property = AppraiseProperty::where('id_appraisal',$appraisal->id_appraisal)->first();
        $sell_property = SellProperty::where('id_appraisal',$appraisal->id_appraisal)->first();
        return response()->json(["<label>Appraisal Value: PhP ".number_format($appraisal_property->total_property_value,2)."</label>",$appraisal->id_appraisal,$sell_property]);
    }

    public function changePassword(Request $request){
        $user = User::find(Auth::user()->id_user);
        if (!is_null($user)){
            $user->update_date = Carbon::now();
            $user->password = Hash::make($request->strPassword);
            $user->save();
            return "success";
        }else{
            return "error";	
        }
    }
}
