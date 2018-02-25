<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;
use App\Models\Province;
use App\Models\City;
use App\Http\Requests;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with('province')->where('ind_deleted',0)
        ->orderBy('city_code')
        ->get();
        $provinces = Province::where('ind_deleted',0)
        ->orderBy('province_code')
        ->get();
        return view('city.index', compact('cities','provinces'));
    }

    public function filter(Request $request){
    	$cities = City::with('province')->where('ind_deleted', $request->selFilterValue)
            ->orderBy('city_code', 'asc')
            ->get();
        if($request->selFilterValue == 0){
            return view('city.Table.CityTable', compact('cities'));
        }else{
            return view('city.Table.CityDeleteTable', compact('cities'));
        }            
        
    }

    public function getCityData(){
        return City::with('province')->where('ind_deleted', 0)
        ->orderBy('city_code')
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            City::create([
                'id_province' => trim($request->province),
                'city_code' => trim($request->code),
                'city_description' => trim($request->description)
            ]);
            DB::commit();
            $cities = $this->getCityData();
            return view('city.Table.CityTable', compact('cities'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return view('errors.404');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        return view('city.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.404');        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $city = City::findOrFail(trim($request->id));
            $city->update([
                'id_province' => trim($request->province),
                'city_code' => trim($request->code),
                'city_description' => trim($request->description),
                'update_date' => Carbon::now()                
            ]);
            DB::commit();
            $cities = $this->getCityData();
            return view('city.Table.CityTable', compact('cities'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            $city = City::findOrFail(trim($request->id));
            $city->update([
                'ind_deleted' => 1,
                'delete_date' => Carbon::now()
            ]);
            DB::commit();
            $cities = $this->getCityData();
            return view('city.Table.CityTable', compact('cities'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }

    public function reactivate(Request $request)
    {
        try{
            DB::beginTransaction();
            $city = City::findOrFail(trim($request->id));
            $city->update([
                'ind_deleted' => 0,
                'udpate_date' => Carbon::now(),
                'delete_date' => "0000-00-00 00:00:00"
            ]);
            DB::commit();
            $cities = $this->getCityData();
            return view('city.Table.CityTable', compact('cities'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }
}
