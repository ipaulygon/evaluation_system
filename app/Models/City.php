<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_city';
	protected $primaryKey = 'id_city';
	protected $fillable = [
		'id_province',
    	'city_code',
    	'city_description',	
		'update_date',
		'delete_date',
		'ind_deleted'
	];
	
	public function province(){
        return $this->belongsTo('App\Models\Province','id_province');
    }
}
