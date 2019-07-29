<?php

namespace App\Http\Controllers\Api;

use App\Timbangan as Master;
use App\Mesin as Mesin;
use App\Palet as Palet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;
use Carbon\Carbon;

class TimbanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $data = Master::where('hapus',1)->where("created_by",$request->user()->id);
        
        if(!empty(request('packing_id')))
        {
            $data->where('packing_id',request('packing_id'));
        }
        
        if(!empty(request('palet_id')))
        {
            $data->where('palet_id',request('palet_id'));
        }
        
        if(!empty(request('material')))
        {
            $data->where('material','like','%'.request('material').'%');
        }    
        
        if(!empty(request('batch')))
        {
            $data->where('batch','like','%'.request('batch').'%');
        }   
        
        if(!empty(request('tipe_berat')) && request('tipe_berat')!="null")
        {
            $data->where('tipe_berat','like','%'.request('tipe_berat').'%');
        } 
        
        if(!empty(request('date_start')))
        {
            $sdt = Carbon::createFromFormat('d-m-Y', request('date_start'));
            if(!empty(request('date_end')))
            {
                $edt = Carbon::createFromFormat('d-m-Y', request('date_end'));
                $data->where(function($query) use ($sdt, $edt)
                {
                    $query->whereRaw("date_format(created_at,'%Y-%m-%d') between '".$sdt->toDateString()."' and '".$edt->toDateString()."'");
                });
            }
            else
            {
                $data->whereDate('created_at',$sdt->toDateString());
            }
        }
        
        if(!empty(request('reg')))
        {
            $reg = request('reg');
            if(!empty(request('regEnd')))
            {
                $regEnd = request('regEnd');
                $data->where(function($query) use($reg, $regEnd)
                {
                    $query->whereBetween('no',[$reg, $regEnd]);
                });
            }
            else
            {
                $data->where('no',$reg);
            }
        }
        
        if(empty(request('withLimit')))
            $data->limit(200);
        $data->orderBy('id','desc');
        
        return Fractal::includes('timbangan')->collection($data->get(), new \App\Transformers\TimbanganTransformer());
    }
    
    public function proses(Request $request)
    {
        $data = Master::where('hapus',1)
                ->where("created_by",$request->user()->id)
                ->where(function($q)
                {
                    $q->where('palet_id',"");
                    $q->orWhere('palet_id',null);
                })
                ->where('packing_id',request("packing_id"));
                
        $data->orderBy('id','desc');
        
        return Fractal::includes('timbangan')->collection($data->get(), new \App\Transformers\TimbanganTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = $this->validate($request, [
            'no'            => 'required',
            'material'      => 'required',
            'warna_cones'   => 'required',
            'batch'         => 'required',
            'mill'          => 'required',
            'tare_cones'    => 'required',
            'tare_lain'     => 'required',
            'tipe_berat'    => 'required',
            'standar'       => 'required',
            'actual'        => 'required',
//            'total_cones'   => 'required',
//            'berat_papan'     => 'required',
            'packing_id'    => 'required',
        ],[
            'no.required' => 'No Register harus diisi.',
            'material.required'  => 'Kode Material harus diisi.',
            'warna_cones.required'  => 'Warna Cones harus diisi.',
            'batch.required'  => 'Batch harus diisi.',
            'mill.required'  => 'Kode Mill harus diisi.',
            'tare_cones.required'  => 'Tare Cones harus diisi.',
            'tare_lain.required'  => 'Tare Lain harus diisi.',
            'tipe_berat.required'  => 'Tipe berat harus diisi.',
            'standar.required'  => 'Berat Standar harus diisi.',
            'actual.required'  => 'Berat Aktual harus diisi.',
//            'total_cones.required'  => 'Total Cones harus diisi.',
//            'berat_papan.required'  => 'Tipe berat harus diisi.',
            'packing_id.required'  => 'Material harus dipilih.',
        ]);
        
        
        
        $data = $request->all();
        
        if(trim($data['tipe_berat'])=="SISA CONES")
        {
            $data['bruto'] = $data['berat_sc'] + (trim($data['tare_cones']) + trim($data['tare_lain']));
        }
        
        $data['created_by'] = $request->user()->id;
        $data['created_at'] = Carbon::now();
        $data['updated_by'] = $request->user()->id;
        $data['updated_at'] = Carbon::now();
        
        $var = Master::create($data);
        
        echo json_encode(array("id" => $var->id));
    }
    
    public function storePalet(Request $request)
    {
        if(!empty(request("packing_id")))
        {
            $mData = Master::where("packing_id",request("packing_id"))
                    ->where("created_by",$request->user()->id)
                    ->where("palet_id",null)
                    ->orderBy("id",'ASC')
                    ->get();
            
            $data = array();
            
            $i = 0;
            
            $data['tTare_cones'] = 0;
            $data['tTare_lain'] = 0;
            $data['tQty'] = 0;
            $data['tBerat_sc'] = 0;
            $data['tStandar'] = 0;
            $data['tActual'] = 0;
            $data['tTotal_cones'] = 0;
            $data['tBerat_papan'] = 0;
            $data['tBruto'] = 0;
            
            foreach($mData as $v)
            {
                if($i==0)
                {
                    $data['material'] = $v->material;
                    $data['warna_cones'] = $v->warna_cones;
                    $data['batch']      = $v->batch;
                    $data['mill']   = $v->mill;
                    $data['tipe_berat']   = $v->tipe_berat;
                    $data['deskripsi']   = $v->deskripsi;
                    $data['start_no'] = $v->no;
                }
                else
                {
                    $data['end_no'] = $v->no;
                }
                
                $data['tTare_cones'] += floatval($v->tare_cones);
                $data['tTare_lain'] += floatval($v->tare_lain);
                $data['tQty'] += (int)$v->qty;
                $data['tBerat_sc'] += floatval($v->berat_sc);
                $data['tStandar'] += floatval($v->standar);
                $data['tActual'] += floatval($v->actual);
                $data['tTotal_cones'] += floatval($v->total_cones);
                $data['tBerat_papan'] += floatval($v->berat_papan);
                $data['tBruto'] += floatval($v->bruto);
                
                $i++;
            }
            
            $data['created_by'] = $request->user()->id;
            $data['created_at'] = Carbon::now();
            $data['updated_by'] = $request->user()->id;
            $data['updated_at'] = Carbon::now();
//            print_r($data);
            $paletId = Palet::create($data);
            
            if($paletId->id > 0)
            {
                $uTimbang = array(
                    "palet_id"  => $paletId->id,
                    "updated_by"=> $request->user()->id,
                    "updated_at"=> Carbon::now()
                );
                $timbang = Master::where("packing_id",request("packing_id"))
                                    ->where("created_by",$request->user()->id)
                                    ->where("palet_id",null)
                                    ->update($uTimbang);
                
                echo json_encode(array("id" => $paletId->id));
            }
        }
        else
        {
            echo json_encode(array("id" => ""));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    
    public function registerNumber(Request $request)
    {
        $mesinId = $request->user()->mesin_id;
        
        $mesin = Mesin::where('id',$mesinId)->first();
        
        $register_start = $mesin->register_start;
        $register_end   = $mesin->register_end;
        
        $counting = Master::where('packing_id',request('packing_id'))->where('mill',$mesin->kode)->where('hapus',1)->count();
        
        if($counting>0)
        {
            $register_start = Master::where('packing_id',request('packing_id'))->where('mill',$mesin->kode)->where('hapus',1)->min('no');
        }
        
        $registerNum = $register_start+$counting;
        
        echo json_encode(array('reg_num' => $registerNum));
    }
    
    public function noReg(Request $request)
    {
        $carbon = Carbon::now();
        
        return json_encode(array("no_reg" => substr($carbon->format('Y'),2).$carbon->format('md')));
    }
}
