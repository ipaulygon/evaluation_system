<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellProperty extends Model
{
    public $timestamps = false;
	protected $table = 'tbl_sell_property';
	protected $primaryKey = 'id_sell_property';
	protected $fillable = [
		'create_date',
    	'update_date',
		'id_appraisal',
		'price',
		'remarks',
		'counter'
	];

	public function appraisal(){
        return $this->belongsTo('App\Models\Appraisal','id_appraisal','id_appraisal');
    }
}

