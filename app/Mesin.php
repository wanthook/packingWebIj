<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    public $timestamps = false;
    
    protected $table = 'mesin';
    
    protected $fillable = [
        'nama', 
        'kode',
        'mesin',
        'register_start',
        'register_end',
        'hapus', 
        'created_by', 
        'created_at', 
        'updated_by', 
        'updated_at'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
    
    public function createduser()
    {
        return $this->hasMany('App\User','id','created_by');
    }
    
    public function updateduser()
    {
        return $this->hasMany('App\User','id','updated_by');
    }
    
    public function getCreatedAtAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    
    public function formCreatedAtAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    
    public function formUpdatedAtAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
