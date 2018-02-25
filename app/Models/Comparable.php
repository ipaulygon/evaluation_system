<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comparable extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_comparable_property';
	protected $primaryKey = 'id_comparable_property';


	public function propertyLocation(){
		return $this->hasOne('\App\Models\PropertyLocation', 'id_property_location', 'id_property_location');
	}
	
}
