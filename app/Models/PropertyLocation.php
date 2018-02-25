<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyLocation extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_property_location';
	protected $primaryKey = 'id_property_location';

	public function barangay(){
		return $this->belongsTo('App\Models\Barangay','id_barangay');
	}
}
