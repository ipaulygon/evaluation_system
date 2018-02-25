<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
	public $timestamps = false;
	protected $table = 'tbl_seller';
	protected $primaryKey = 'id_seller';

    protected $fillable = [
        'id_user','first_name', 'middle_name', 'last_name',
    ];

	public function user(){
		return $this->belongsTo('\App\User');
	}

	
}
