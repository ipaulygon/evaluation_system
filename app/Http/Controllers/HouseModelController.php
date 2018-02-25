<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;
use App\Models\HouseModel;
use App\Http\Requests;

class HouseModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = HouseModel::where('ind_deleted', 0)
        ->orderBy('house_model')
        ->get();
        return view('house_model.index', compact('models'));
    }

    public function filter(Request $request){
    	$models = HouseModel::where('ind_deleted', $request->selFilterValue)
            ->orderBy('house_model', 'asc')
            ->get();
        if($request->selFilterValue == 0){
            return view('house_model.Table.HouseModelTable', compact('models'));
        }else{
            return view('house_model.Table.HouseModelDeleteTable', compact('models'));
        }
        
    }


    public function getHouseModelData(){
        return HouseModel::where('ind_deleted', 0)
        ->orderBy('house_model')
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
            HouseModel::create([
                'house_model' => trim($request->code),
                'description' => trim($request->description)
            ]);
            DB::commit();
            $models = $this->getHouseModelData();
            return view('house_model.Table.HouseModelTable', compact('models'));
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
        $model = HouseModel::findOrFail($id);
        return view('house_model.show', compact('model')); 
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
            $model = HouseModel::findOrFail(trim($request->id));
            $model->update([
                'house_model' => trim($request->code),
                'description' => trim($request->description),
                'update_date' => Carbon::now()
            ]);
            DB::commit();
            $models = $this->getHouseModelData();
            return view('house_model.Table.HouseModelTable', compact('models'));
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
            $model = HouseModel::findOrFail(trim($request->id));
            $model->update([
                'ind_deleted' => 1,
                'delete_date' => Carbon::now()                
            ]);
            DB::commit();
            $models = $this->getHouseModelData();
            return view('house_model.Table.HouseModelTable', compact('models'));
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
            $model = HouseModel::findOrFail(trim($request->id));
            $model->update([
                'ind_deleted' => 0,
                'udpate_date' => Carbon::now(),
                'delete_date' => "0000-00-00 00:00:00"
            ]);
            DB::commit();
            $models = $this->getHouseModelData();
            return view('house_model.Table.HouseModelTable', compact('models'));
        }catch (\Illuminate\Database\QueryException $e){
	        DB::rollBack();	
	        //return $e->getMessage(); for debugging
	        return "error";
        }
    }
}
