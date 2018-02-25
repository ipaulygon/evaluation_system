<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_barangay';
	protected $primaryKey = 'id_barangay';
	protected $fillable = [
		'id_city',
    	'barangay_code',
    	'barangay_description',	
		'update_date',
		'delete_date',
		'ind_deleted'
	];
	
	public function city(){
        return $this->belongsTo('App\Models\City','id_city');
    }
}
