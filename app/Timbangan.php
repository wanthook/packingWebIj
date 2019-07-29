<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timbangan extends Model
{
     public $timestamps = false;
    
    protected $table = 'timbangan';
    
    protected $fillable = [
        'no', 
        'material',
        'warna_cones',
        'batch', 
        'mill',
        'tare_cones',
        'tare_lain', 
        'tipe_berat',
        'deskripsi',
        'qty',
        'standar', 
        'actual',
        'berat_sc',
        'total_cones',
        'berat_papan', 
        'no_reg',
        'bruto',
        'packing_id',
        'palet_id',
        'download_id',
        'hapus', 
        'created_by', 
        'created_at', 
        'updated_by', 
        'updated_at'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
    
    public function packing()
    {
        return $this->belongsTo('App\Packing','packing_id');
    }
    
    public function palet()
    {
        return $this->belongsTo('App\Palet','palet_id');
    }
    
    public function download()
    {
        return $this->belongsTo('App\Download','download_id');
    }
    
    public function createduser()
    {
        return $this->belongsTo('App\User','created_by');
    }
    
    public function updateduser()
    {
        return $this->belongsTo('App\User','updated_by');
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
