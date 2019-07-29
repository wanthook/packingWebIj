<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    public $timestamps = false;
    
    protected $table = 'packing';
    
//    protected $dateFormat = 'Y-m-d';
    
    protected $fillable = [
        'material', 
        'warna_cones',
        'batch',
        'berat_material',
        'tare_cones',
        'tare_lain',
        'bruto',
        'berat_id', 
        'hapus', 
        'created_by', 
        'updated_by',
        'created_at',
        'updated_at'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    public function berat()
    {
        return $this->belongsTo('App\Berat');
    }
    
    public function timbangan()
    {
        return $this->hasMany('App\Timbangan');
    }
    
    public function createduser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
    
    public function updateduser()
    {
        return $this->belongsTo('App\User','updated_by','id');
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
