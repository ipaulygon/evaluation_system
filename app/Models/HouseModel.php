<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseModel extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_house_model';
	protected $primaryKey = 'id_house_model';
	protected $fillable = [
    	'house_model',
		'description',	
		'update_date',
		'delete_date',
		'ind_deleted'
    ];
}
