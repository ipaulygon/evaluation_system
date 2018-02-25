<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraisalDetails extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_appraisal_Details';
	protected $primaryKey = 'id_appraisal_details';

	public function Appraisal(){
		return $this->hasOne('\App\Models\Appraisal','id_appraisal','id_appraisal');
	}

	
}
