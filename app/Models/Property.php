<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_property';
	protected $primaryKey = 'id_property';

	public function seller(){
		return $this->hasOne('\App\Models\Seller','id_seller', 'id_seller');
	}

	public function propertyLocation(){
		return $this->hasOne('\App\Models\PropertyLocation', 'id_property_location', 'id_property_location');
	}

	public function appraisal(){
		return $this->belongsTo('\App\Models\Appraisal','id_property','id_property')->orderBy('create_date','desc');
	}

	public function pictures(){
		return $this->hasMany('\App\Models\AppraisePropertyPicture','id_property','id_property');
	}
}
