<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;
    protected $fillable = [
        'email', 'password', 'user_type',
    ];
    protected $primaryKey = 'id_user';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function seller(){
        return $this->hasOne('\App\Models\Seller','id_user');
    }

    public function appraiser(){
        return $this->hasOne('\App\Models\Appraiser','id_user');
    }
}
