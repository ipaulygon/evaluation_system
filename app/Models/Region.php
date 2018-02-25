<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_region';
	protected $primaryKey = 'id_region';
	protected $fillable = [
    	'region_code',
		'region_description',	
		'update_date',
		'delete_date',
		'ind_deleted'
    ];
}
