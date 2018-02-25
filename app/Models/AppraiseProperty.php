<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraiseProperty extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_appraise_property';
	protected $primaryKey = 'id_appraise_property';

	public function appraisal(){
		return $this->hasOne('\App\Models\Appraisal','id_appraisal','id_appraisal');
	}

	
}
