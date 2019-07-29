<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'api_token', 
        'username', 
        'photo', 
        'ttd_img', 
        'type',
        'mesin_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];
    
    public function findForPassport($username) {
        return $this->where('username', $username)->first();
    }
    
    public function mesin()
    {
        return $this->hasOne('App\Mesin');
    }
    
}
