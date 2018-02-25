<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraisePropertyPicture extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_appraisal_property_picture';
	protected $primaryKey = 'id_property_picture';

	public function appraiseProperty(){
		return $this->hasOne('\App\Models\AppraiseProperty','id_appraise_property','id_appraise_property');
	}

    
	
}
