<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;
use App\Models\City;
use App\Models\Barangay;
use App\Http\Requests;

class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangays = Barangay::with('city')->where('ind_deleted',0)
        ->orderBy('barangay_code')
        ->get();
        $cities = City::where('ind_deleted',0)
        ->orderBy('city_code')
        ->get();
        return view('barangay.index', compact('barangays','cities'));
    }

    public function filter(Request $request){
    	$barangays = Barangay::with('city')->where('ind_deleted', $request->selFilterValue)
            ->orderBy('barangay_code', 'asc')
            ->get();
        if($request->selFilterValue == 0){
            return view('barangay.Table.BarangayTable', compact('barangays'));
        }else{
            return view('barangay.Table.BarangayDeleteTable', compact('barangays'));
        }            
        
    }

    public function getBarangayData(){
        return Barangay::with('city')->where('ind_deleted', 0)
        ->orderBy('barangay_code')
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
            Barangay::create([
                'id_city' => trim($request->city),
                'barangay_code' => trim($request->code),
                'barangay_description' => trim($request->description)
            ]);
            DB::commit();
            $barangays = $this->getBarangayData();
            return view('barangay.Table.BarangayTable', compact('barangays'));
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
        $barangay = Barangay::findOrFail($id);
        return view('barangay.show', compact('barangay'));
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
            $barangay = Barangay::findOrFail(trim($request->id));
            $barangay->update([
                'id_city' => trim($request->city),
                'barangay_code' => trim($request->code),
                'barangay_description' => trim($request->description),
                'update_date' => Carbon::now()
            ]);
            DB::commit();
            $barangays = $this->getBarangayData();
            return view('barangay.Table.BarangayTable', compact('barangays'));
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
            $barangay = Barangay::findOrFail(trim($request->id));
            $barangay->update([
                'ind_deleted' => 1,
                'delete_date' => Carbon::now()
            ]);
            DB::commit();
            $barangays = $this->getBarangayData();
            return view('barangay.Table.BarangayTable', compact('barangays'));
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
            $barangay = Barangay::findOrFail(trim($request->id));
            $barangay->update([
                'ind_deleted' => 0,
                'udpate_date' => Carbon::now(),
                'delete_date' => "0000-00-00 00:00:00"
            ]);
            DB::commit();
            $barangays = $this->getBarangayData();
            return view('barangay.Table.BarangayTable', compact('barangays'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }
}
