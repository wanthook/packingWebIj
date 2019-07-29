<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    public $timestamps = false;
    
    protected $table = 'download';
    
//    protected $dateFormat = 'Y-m-d';
    
    protected $fillable = [
        'tanggal_unduh', 
        'nama_file',
        'jumlah_data',
        'hapus', 
        'created_by', 
        'created_at'
    ];
    
    protected $dates = [
        'created_at',
        'tanggal_unduh'
    ];
    
    public function timbangan()
    {
        return $this->hasMany('App\Timbangan');
    }
    
    public function createduser()
    {
        return $this->belongsTo('App\User','created_by','id');
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
    
    public function getTanggalDownloadAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    
    public function formTanggalDownloadAttribute($value)
    {
        if(empty($value) || is_null($value))
        {
            return "";
        }
        
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
