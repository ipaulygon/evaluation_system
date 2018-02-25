<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_province';
	protected $primaryKey = 'id_province';
	protected $fillable = [
		'id_region',
    	'province_code',
		'province_description',	
		'update_date',
		'delete_date',
		'ind_deleted'
	];
	
	public function region(){
        return $this->belongsTo('App\Models\Region','id_region');
    }
}
