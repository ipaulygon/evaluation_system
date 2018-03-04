<?php
use Illuminate\Support\Facades\Input;
use App\Models\Province;
use App\Models\City;
use App\Models\Barangay;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/','HomeController@index');

Route::post("/change_region","HomeController@ChangeRegion");
Route::post("/change_province","HomeController@ChangeProvince");
Route::post("/change_city","HomeController@ChangeCity");
Route::get("/show_property/{id}","HomeController@ShowProperty");
Route::post("/property_count","HomeController@PropertyCount");
Route::post("/get_statistics","HomeController@Statistics");
Route::post("/get_appraised_value","HomeController@AppraisedValue");
// Route::get('/appraised_property', function(){
//     return view('appraiser.appraised');
// });

Route::post("/get_search","HomeController@GetSearch");

Route::auth();

// Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', function(){
        if (Auth::user()->user_type == 0) {
            return Redirect::to('/appraisers');
        }else if(Auth::user()->user_type == 1){
            return Redirect::to('/request_appraisals');
        }else if(Auth::user()->user_type == 2 && Auth::user()->seller->ind_active==1){
            return Redirect::to('/my_properties');
        }else{
            \Auth::logout();
            // $request->session()->flash('error', "You are still pending for selling properties.");
            return Redirect::to('/login');
        }
    });
    Route::group(['middleware'=>'admin'], function(){
        //----------appraiser----------//
        Route::get('/appraisers', array(
            'uses' => 'appraiserController@index',
            'as' => 'appraiser.index'
        ));
        Route::post('/appraiser/create', array(
            'uses' => 'appraiserController@create',
            'as' => 'appraiser.create'
        ));
        Route::post('/appraiser/update', array(
            'uses' => 'appraiserController@update',
            'as' => 'appraiser.update'
        ));
        Route::post('/appraiser/resetpassword', array(
            'uses' => 'appraiserController@resetpassword',
            'as' => 'appraiser.resetpassword'
        ));
        Route::post('/appraiser/filter', array(
            'uses' => 'appraiserController@filter',
            'as' => 'appraiser.filter'
        ));
        Route::post('/appraiser/suspend', array(
            'uses' => 'appraiserController@suspend',
            'as' => 'appraiser.suspend'
        ));
        Route::post('/appraiser/restore', array(
            'uses' => 'appraiserController@restore',
            'as' => 'appraiser.restore'
        ));
        Route::get('/appraiser/show/{id}', array(
            'uses' => 'appraiserController@show',
            'as' => 'appraiser.show'
        ));
        Route::get('/appraiser/data', array(
            'uses' => 'appraiserController@getEnforcerData',
            'as' => 'appraiser.data'
        ));
        Route::get('/sellers', array(
            'uses' => 'sellerController@index',
            'as' => 'seller.index'
        ));
        Route::post('/seller/filter', array(
            'uses' => 'sellerController@filter',
            'as' => 'seller.filter'
        ));
        Route::post('/seller/suspend', array(
            'uses' => 'sellerController@suspend',
            'as' => 'seller.suspend'
        ));
        Route::post('/seller/restore', array(
            'uses' => 'sellerController@restore',
            'as' => 'seller.restore'
        ));
        Route::post('/seller/accept', array(
            'uses' => 'sellerController@accept',
            'as' => 'seller.accept'
        ));
        // Maintenance ------//
        // Regions
        Route::get('/regions', array(
            'uses' => 'RegionController@index',
            'as' => 'region.index'
        ));
        Route::post('/regions/filter', array(
            'uses' => 'RegionController@filter',
            'as' => 'region.filter'
        ));
        Route::post('/regions/create', array(
            'uses' => 'RegionController@create',
            'as' => 'region.create'
        ));
        Route::get('/regions/show/{id}', array(
            'uses' => 'RegionController@show',
            'as' => 'region.show'
        ));
        Route::post('/regions/update', array(
            'uses' => 'RegionController@update',
            'as' => 'region.update'
        ));
        Route::post('/regions/delete', array(
            'uses' => 'RegionController@delete',
            'as' => 'region.delete'
        ));
        Route::post('/regions/reactivate', array(
            'uses' => 'RegionController@reactivate',
            'as' => 'region.reactivate'
        ));
        // End of region
        // Province
        Route::get('/provinces', array(
            'uses' => 'ProvinceController@index',
            'as' => 'province.index'
        ));
        Route::post('/provinces/filter', array(
            'uses' => 'ProvinceController@filter',
            'as' => 'province.filter'
        ));
        Route::post('/provinces/create', array(
            'uses' => 'ProvinceController@create',
            'as' => 'province.create'
        ));
        Route::get('/provinces/show/{id}', array(
            'uses' => 'ProvinceController@show',
            'as' => 'province.show'
        ));
        Route::post('/provinces/update', array(
            'uses' => 'ProvinceController@update',
            'as' => 'province.update'
        ));
        Route::post('/provinces/delete', array(
            'uses' => 'ProvinceController@delete',
            'as' => 'province.delete'
        ));
        Route::post('/provinces/reactivate', array(
            'uses' => 'ProvinceController@reactivate',
            'as' => 'province.reactivate'
        ));
        // End of province
        // City
        Route::get('/cities', array(
            'uses' => 'CityController@index',
            'as' => 'city.index'
        ));
        Route::post('/cities/filter', array(
            'uses' => 'CityController@filter',
            'as' => 'city.filter'
        ));
        Route::post('/cities/create', array(
            'uses' => 'CityController@create',
            'as' => 'city.create'
        ));
        Route::get('/cities/show/{id}', array(
            'uses' => 'CityController@show',
            'as' => 'city.show'
        ));
        Route::post('/cities/update', array(
            'uses' => 'CityController@update',
            'as' => 'city.update'
        ));
        Route::post('/cities/delete', array(
            'uses' => 'CityController@delete',
            'as' => 'city.delete'
        ));
        Route::post('/cities/reactivate', array(
            'uses' => 'CityController@reactivate',
            'as' => 'city.reactivate'
        ));
        // End of cities
        // Barangay
        Route::get('/barangays', array(
            'uses' => 'BarangayController@index',
            'as' => 'barangay.index'
        ));
        Route::post('/barangays/filter', array(
            'uses' => 'BarangayController@filter',
            'as' => 'barangay.filter'
        ));
        Route::post('/barangays/create', array(
            'uses' => 'BarangayController@create',
            'as' => 'barangay.create'
        ));
        Route::get('/barangays/show/{id}', array(
            'uses' => 'BarangayController@show',
            'as' => 'barangay.show'
        ));
        Route::post('/barangays/update', array(
            'uses' => 'BarangayController@update',
            'as' => 'barangay.update'
        ));
        Route::post('/barangays/delete', array(
            'uses' => 'BarangayController@delete',
            'as' => 'barangay.delete'
        ));
        Route::post('/barangays/reactivate', array(
            'uses' => 'BarangayController@reactivate',
            'as' => 'barangay.reactivate'
        ));
        // End of barangay
        // HouseModel
        Route::get('/housemodels', array(
            'uses' => 'HouseModelController@index',
            'as' => 'housemodel.index'
        ));
        Route::post('/housemodels/filter', array(
            'uses' => 'HouseModelController@filter',
            'as' => 'housemodel.filter'
        ));
        Route::post('/housemodels/create', array(
            'uses' => 'HouseModelController@create',
            'as' => 'housemodel.create'
        ));
        Route::get('/housemodels/show/{id}', array(
            'uses' => 'HouseModelController@show',
            'as' => 'housemodel.show'
        ));
        Route::post('/housemodels/update', array(
            'uses' => 'HouseModelController@update',
            'as' => 'housemodel.update'
        ));
        Route::post('/housemodels/delete', array(
            'uses' => 'HouseModelController@delete',
            'as' => 'housemodel.delete'
        ));
        Route::post('/housemodels/reactivate', array(
            'uses' => 'HouseModelController@reactivate',
            'as' => 'housemodel.reactivate'
        ));
        // End of housemodel
    });
    Route::group(['middleware'=>'appraiser'], function(){
        Route::post('/appraised', array(
            'uses' => 'appraiserController@appraise',
            'as' => 'appraiser.appraise'
        ));       
        Route::get('/request_appraisals', array(
            'uses' => 'appraiserController@load_request_appraisal',
            'as' => 'appraiser.request_appraisals'
        ));
        Route::get('/appraise_property/{id}', array(
            'uses' => 'appraiserController@load_appraisal',
            'as' => 'appraiser.appraise'
        ));
        Route::post('/view_appraised_property','appraiserController@viewAppraisal');
        Route::post('/reject_property','appraiserController@rejectAppraisal');
    });
    Route::group(['middleware'=>'seller'], function(){
        Route::get('/my_properties', array(
            'uses' => 'propertyController@index',
            'as' => 'seller.my_properties'
        ));
        Route::post('/my_properties/create', array(
            'uses' => 'propertyController@create',
            'as' => 'seller.create'
        ));
        Route::post('/my_properties/request_appraisal', array(
            'uses' => 'propertyController@request_appraisal',
            'as' => 'seller.request_appraisal'
        ));
        Route::post('/publish_property', 'sellerController@PublishProperty');
        Route::post('/sold_property', 'sellerController@SoldProperty');
        Route::post('/add_property_images','sellerController@uploadImage');
        Route::post('/view_property','sellerController@viewProperty');        
        Route::post('/remove_picture','sellerController@removePicture'); 
        Route::post('/remove_property', 'propertyController@suspend');     
    });
});

// Route::get('/get_provinces',function(){
//     $id_region = Input::get('id_region');
//     $provinces= Province::where('id_region','=',$id_region)->get();
//     return Response::json($provinces);
// });

// Route::get('/get_cities',function(){
//     $id_province = Input::get('id_province');
//     $cities= City::where('id_province','=',$id_province)->get();
//     return Response::json($cities);
// });

// Route::get('/get_barangays',function(){
//     $id_city = Input::get('id_city');
//     $barangays= Barangay::where('id_city','=',$id_city)->get();
//     return Response::json($barangays);
// });


