<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraiser extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_appraiser';
	protected $primaryKey = 'id_appraiser';

	public function User(){
		return $this->belongsTo('\App\User');
	}

	
}
