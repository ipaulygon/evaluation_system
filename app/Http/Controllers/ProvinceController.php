<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;
use App\Models\Region;
use App\Models\Province;
use App\Http\Requests;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::with('region')->where('ind_deleted', 0)
        ->orderBy('province_code')
        ->get();
        $regions = Region::where('ind_deleted', 0)
        ->orderBy('region_code')
        ->get();
        return view('province.index', compact('provinces','regions'));
    }

    public function filter(Request $request){
    	$provinces = Province::with('region')->where('ind_deleted', $request->selFilterValue)
            ->orderBy('province_code', 'asc')
            ->get();
        if($request->selFilterValue == 0){
            return view('province.Table.ProvinceTable', compact('provinces'));
        }else{
            return view('province.Table.ProvinceDeleteTable', compact('provinces'));
        }            
        
    }

    public function getProvinceData(){
        return Province::with('region')->where('ind_deleted', 0)
        ->orderBy('province_code')
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
            Province::create([
                'id_region' => trim($request->region),
                'province_code' => trim($request->code),
                'province_description' => trim($request->description)
            ]);
            DB::commit();
            $provinces = $this->getProvinceData();
            return view('province.Table.ProvinceTable', compact('provinces'));
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
        $province = Province::findOrFail($id);
        return view('province.show', compact('province'));
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
            $province = Province::findOrFail(trim($request->id));
            $province->update([
                'id_region' => trim($request->region),
                'province_code' => trim($request->code),
                'province_description' => trim($request->description),
                'update_date' => Carbon::now()
            ]);
            DB::commit();
            $provinces = $this->getProvinceData();
            return view('province.Table.ProvinceTable', compact('provinces'));
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
            $province = Province::findOrFail(trim($request->id));
            $province->update([
                'ind_deleted' => 1,
                'delete_date' => Carbon::now()
            ]);
            DB::commit();
            $provinces = $this->getProvinceData();
            return view('province.Table.ProvinceTable', compact('provinces'));
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
            $province = Province::findOrFail(trim($request->id));
            $province->update([
                'ind_deleted' => 0,
                'udpate_date' => Carbon::now(),
                'delete_date' => "0000-00-00 00:00:00"
            ]);
            DB::commit();
            $provinces = $this->getProvinceData();
            return view('province.Table.ProvinceTable', compact('provinces'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }
}
