<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;
use App\Models\Region;
use App\Http\Requests;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::where('ind_deleted', 0)
        ->orderBy('region_code')
        ->get();
        return view('region.index', compact('regions'));
    }

    public function filter(Request $request){
    	$regions = Region::where('ind_deleted', $request->selFilterValue)
            ->orderBy('region_code', 'asc')
            ->get();
        if($request->selFilterValue == 0){
            return view('region.Table.RegionTable', compact('regions'));
        }else{
            return view('region.Table.RegionDeleteTable', compact('regions'));
        }
        
    }


    public function getRegionData(){
        return Region::where('ind_deleted', 0)
        ->orderBy('region_code')
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
            Region::create([
                'region_code' => trim($request->code),
                'region_description' => trim($request->description)
            ]);
            DB::commit();
            $regions = $this->getRegionData();
            return view('region.Table.RegionTable', compact('regions'));
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
        $region = Region::findOrFail($id);
        return view('region.show', compact('region')); 
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
            $region = Region::findOrFail(trim($request->id));
            $region->update([
                'region_code' => trim($request->code),
                'region_description' => trim($request->description),
                'update_date' => Carbon::now()
            ]);
            DB::commit();
            $regions = $this->getRegionData();
            return view('region.Table.RegionTable', compact('regions'));
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
            $region = Region::findOrFail(trim($request->id));
            $region->update([
                'ind_deleted' => 1,
                'delete_date' => Carbon::now()                
            ]);
            DB::commit();
            $regions = $this->getRegionData();
            return view('region.Table.RegionTable', compact('regions'));
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
            $region = Region::findOrFail(trim($request->id));
            $region->update([
                'ind_deleted' => 0,
                'udpate_date' => Carbon::now(),
                'delete_date' => "0000-00-00 00:00:00"
            ]);
            DB::commit();
            $regions = $this->getRegionData();
            return view('region.Table.RegionTable', compact('regions'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }
}
