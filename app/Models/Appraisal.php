<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_appraisal';
	protected $primaryKey = 'id_appraisal';

	public function Property(){
		return $this->hasOne('\App\Models\Property','id_property','id_property');
	}

	public function SellProperty(){
		return $this->belongsTo('\App\SellProperty','id_appraisal','id_appraisal');
	}

	public function appraiseProperty(){
		return $this->belongsTo('\App\Models\AppraiseProperty','id_appraisal','id_appraisal');
	}
}
