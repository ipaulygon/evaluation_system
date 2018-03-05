<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Hash;
use App\Models\Region;
use App\Models\Province;
use App\Models\City;
use App\Models\Barangay;
use App\Models\HouseModel;
use App\Models\AppraiseProperty;
use App\Models\Property;
use App\Models\Appraisal;
use App\Models\AppraisePropertyPicture;
use App\SellProperty;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = DB::select(DB::raw('
        SELECT 
            p.id_property as id_property, p.property_name as property_name, p.property_type as property_type, p.lot_area as lot_area, sp.price as price, (SELECT picture_path FROM tbl_appraisal_property_picture as ap WHERE ap.id_property=p.id_property LIMIT 1) as picture
            FROM tbl_sell_property AS sp
            JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
            JOIN tbl_property AS p ON a.id_property = p.id_property
            JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
            WHERE p.ind_deleted=0 AND p.property_status = 4
            ORDER BY p.id_property
            LIMIT 6
        '));
        $regions = Region::where('ind_deleted',0)->orderBy('region_code')->get();
        $provinces = Province::where('ind_deleted',0)->where('id_region',$regions->first()->id_region)->orderBy('province_code')->get();
        $cities = City::where('ind_deleted',0)->where('id_province',$provinces->first()->id_province)->orderBy('city_code')->get();
        $barangays = Barangay::where('ind_deleted',0)->where('id_city',$cities->first()->id_city)->orderBy('barangay_code')->get();
        $models = HouseModel::where('ind_deleted',0)->orderBy('house_model')->get();
        return view('welcome',compact('properties','regions','provinces','cities','barangays','models'));
    }

    public function ChangeRegion(Request $request){
        $provinces = Province::where('ind_deleted',0)->where('id_region',$request->region)->orderBy('province_code')->get();
        $cities = City::where('ind_deleted',0)->where('id_province',$provinces->first()->id_province)->orderBy('city_code')->get();
        $barangays = Barangay::where('ind_deleted',0)->where('id_city',$cities->first()->id_city)->orderBy('barangay_code')->get();
        return response()->json(['provinces'=>$provinces, 'cities'=>$cities, "barangays"=>$barangays]);
    }

    public function ChangeProvince(Request $request){
        $cities = City::where('ind_deleted',0)->where('id_province',$request->province)->orderBy('city_code')->get();
        $barangays = Barangay::where('ind_deleted',0)->where('id_city',$cities->first()->id_city)->orderBy('barangay_code')->get();
        return response()->json(['cities'=>$cities, "barangays"=>$barangays]);
    }

    public function ChangeCity(Request $request){
        $barangays = Barangay::where('ind_deleted',0)->where('id_city',$request->city)->orderBy('barangay_code')->get();
        return response()->json(["barangays"=>$barangays]);
    }

    public function ShowProperty($id){
        $property = Property::findOrFail($id);
        return view('buyer.show',compact('property'));
    }

    public function PropertyCount(Request $request){
        $appraisal = Appraisal::where('id_property',$request->id)->first();
        $sell = SellProperty::where('id_appraisal',$appraisal->id_appraisal)->first();
        $sell->counter += 1;
        $sell->save();
        return response()->json('<label>No. of Contacts: '.$sell->counter.'</label>');
    }

    public function AppraisedValue(Request $request){
        $property = Property::findOrFail($request->id);
        $appraisal = Appraisal::where('id_property',$request->id)->orderBy('create_date','desc')->first();
        $appraisal_property = AppraiseProperty::where('id_appraisal',$appraisal->id_appraisal)->first();
        return response()->json(["<label>Appraisal Value: PhP ".number_format($appraisal_property->total_property_value,2)."</label>",$appraisal->id_appraisal]);
    }

    public function GetSearch(Request $request){
        $properties = DB::select(DB::raw('
        SELECT * 
        FROM tbl_sell_property AS sp
        JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
        JOIN tbl_property AS p ON a.id_property = p.id_property
        JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
        WHERE p.ind_deleted=0 AND pl.id_barangay = "'.$request->barangay.'" AND p.property_type = "'.$request->model.'" AND sp.price BETWEEN "'.$request->minbudget.'" AND "'.$request->maxbudget.'" AND p.property_status = 4
        '));;
        return view('search',compact('properties'));
    }

    public function Statistics(Request $request){
        $statement = DB::statement("SET @rank=0;");
        $min = DB::select(DB::raw('
        SELECT MIN(price) as minimum
        FROM tbl_sell_property AS sp
        JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
        JOIN tbl_property AS p ON a.id_property = p.id_property
        JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
        WHERE p.ind_deleted=0 AND pl.id_barangay = "'.$request->barangay.'"  AND p.property_status = 4
        '));
        $current = DB::select(DB::raw('
        SELECT price as current
        FROM tbl_sell_property AS sp
        JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
        JOIN tbl_property AS p ON a.id_property = p.id_property
        JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
        WHERE p.ind_deleted=0 AND p.id_property = "'.$request->property.'"  AND p.property_status = 4
        '));
        $max = DB::select(DB::raw('
        SELECT MAX(price) as maximum
        FROM tbl_sell_property AS sp
        JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
        JOIN tbl_property AS p ON a.id_property = p.id_property
        JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
        WHERE p.ind_deleted=0 AND pl.id_barangay = "'.$request->barangay.'" AND p.property_status = 4
        '));
        $rank = DB::select(DB::raw('
            SELECT p.id_property as property, price, FIND_IN_SET( price, (
                SELECT GROUP_CONCAT( price
                ORDER BY price DESC ) 
                FROM tbl_sell_property AS sp
                JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
                JOIN tbl_property AS p ON a.id_property = p.id_property
                JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
                WHERE p.ind_deleted=0 AND pl.id_barangay = "'.$request->barangay.'" AND p.id_property = "'.$request->property.'" AND p.property_status = 4
                ORDER BY price DESC)
                ) AS rank
            FROM tbl_sell_property AS sp
            JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
            JOIN tbl_property AS p ON a.id_property = p.id_property
            JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
            WHERE p.ind_deleted=0 AND pl.id_barangay = "'.$request->barangay.'" AND p.id_property = "'.$request->property.'" AND p.property_status = 4
            ORDER BY price DESC
        '));
        $all = DB::select(DB::raw('
            SELECT COUNT(p.id_property) as total
            FROM tbl_sell_property AS sp
            JOIN tbl_appraisal AS a ON sp.id_appraisal = a.id_appraisal
            JOIN tbl_property AS p ON a.id_property = p.id_property
            JOIN tbl_property_location AS pl ON p.id_property_location = pl.id_property_location
            WHERE p.ind_deleted=0 AND pl.id_barangay = "'.$request->barangay.'" AND p.property_status = 4
            ORDER BY p.id_property
        '));
        return response()->json(['min'=>$min,'current'=>$current,'max'=>$max,'rank'=>$rank,'all'=>$all]);
    }
}
