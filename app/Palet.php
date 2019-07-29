<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Palet extends Model
{
    public $timestamps = false;
    
    protected $table = 'palet';
    
//    protected $dateFormat = 'Y-m-d';
    
    protected $fillable = [
        'material',
        'warna_cones',
        'batch',
        'mill',
        'tTare_cones', 
        'tTare_lain',
        'tipe_berat',
        'deskripsi',
        'tQty',
        'tBerat_sc',
        'tStandar', 
        'tActual',
        'tTotal_cones',
        'tBerat_papan',
        'tBruto',
        'start_no',
        'end_no',
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
    
    public function timbangan()
    {
        return $this->hasMany('App\Timbangan');
    }
    
    public function createduser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }
    
    public function modifieduser()
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
