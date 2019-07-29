<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePackingRequest;
use App\Packing as Master;
use App\User as Users;
use Auth;
use Yajra\DataTables\DataTables;

class PackingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('packing.list');
    }
    
    public function add()
    {
        $var = new Master;
        
        return view('packing.form',compact('var'));
    }
    
    public function edit($id)
    {
        $var = Master::where('id',$id)->first();
        
        return view('packing.form',compact('var'));
    }
    
    public function save(Request $request)
    {
        $val = $this->validate($request, [
            'material'      => 'required',
            'warna_cones'   => 'required',
            'batch'         => 'required',
            'berat_id'          => 'required',            
            'berat_material'          => 'required',
            'tare_cones'    => 'required',
            'tare_lain'     => 'required',
            'bruto'    => 'required',
        ],[
            'material.required'  => 'Kode Material harus diisi.',
            'warna_cones.required'  => 'Warna Cones harus diisi.',
            'batch.required'  => 'Batch harus diisi.',
            'berat_id.required'  => 'Jenis Berat harus diisi.',
            'tare_cones.required'  => 'Tare Cones harus diisi.',
            'tare_lain.required'  => 'Tare Lain harus diisi.',
            'berat_material.required'  => 'Pastikan Tipe Berat Sudah dipilih.',
            'bruto.required'  => 'Bruto harus diisi.',
        ]);
        
        $data   = $request->all();
        $data['material'] = strtoupper($data['material']);
        $data['warna_cones'] = strtoupper($data['warna_cones']);
        $data['batch'] = strtoupper($data['batch']);
        $data['tare_cones'] = str_replace(",", "", $data['tare_cones']);
        $data['tare_lain'] = str_replace(",", "", $data['tare_lain']);
        $data['created_by'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        $data['updated_by'] = Auth::user()->id;
        $data['updated_at'] = Carbon::now();
        
        $save = Master::create($data);
        return redirect()->route('packing.list')->with("msg","Data berhasil disimpan");
    }
    
    public function change($id,Request $request)
    {
        $val = $this->validate($request, [
            'material'      => 'required',
            'warna_cones'   => 'required',
            'batch'         => 'required',
            'berat_id'          => 'required',            
            'berat_material'          => 'required',
            'tare_cones'    => 'required',
            'tare_lain'     => 'required',
            'bruto'    => 'required',
        ],[
            'material.required'  => 'Kode Material harus diisi.',
            'warna_cones.required'  => 'Warna Cones harus diisi.',
            'batch.required'  => 'Batch harus diisi.',
            'berat_id.required'  => 'Jenis Berat harus diisi.',
            'tare_cones.required'  => 'Tare Cones harus diisi.',
            'tare_lain.required'  => 'Tare Lain harus diisi.',
            'berat_material.required'  => 'Pastikan Tipe Berat Sudah dipilih.',
            'bruto.required'  => 'Bruto harus diisi.',
        ]);
        $data   = $request->all();
        
        $edit = Master::where('id',$id)->first();
        $data['material'] = strtoupper($data['material']);
        $data['warna_cones'] = strtoupper($data['warna_cones']);
        $data['batch'] = strtoupper($data['batch']);
        $data['tare_cones'] = str_replace(",", "", $data['tare_cones']);
        $data['tare_lain'] = str_replace(",", "", $data['tare_lain']);
        $data['updated_by'] = Auth::user()->id;
        $data['updated_at'] = Carbon::now();
        
        $edit->fill($data)->save();
        
        return redirect()->route('packing.list')->with("msg","Data berhasil diubah");
    }
    
    public function dataTables(Request $request)
    {
        $req    = $request->all();
        
        $datas   = Master::with(['createduser','berat'])->where('hapus',1);  
//        print_r($datas->first());
        if(!empty($req['txtSearch']))
        {
//            $datas->where('deskripsi','like','%'.$req['txtSearch'].'%');
            $datas->where(function($q) use($req)
            {
                $q->where('material','like','%'.$req['txtSearch'].'%');
                $q->orWhere('warna_cones','like','%'.$req['txtSearch'].'%');
                $q->orWhere('batch','like','%'.$req['txtSearch'].'%');
            });
        }
//        if(!empty($req['txtTipe']))
//        {
//            $datas->where('tipe',$req['txtTipe']);
//        }
        $datas->orderBy('id','desc');
        
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str    = "";
                    $str    .= '<a href="'.route("packing.ubah",$datas->id).'" class="editrow btn btn-default" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
                    
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function select2(Request $request)
    {
        $ret    = array();
        $datas  = array();
        if($request->input('id'))
        {
            $datas = Master::where('id',$request->input('id'))->whereHapus('1')->limit(10);
        }
        else
        {
            $datas->where(function($q) use($req)
            {
                $q->where('material','like','%'.$req['txtSearch'].'%');
                $q->orWhere('warna_cones','like','%'.$req['txtSearch'].'%');
                $q->orWhere('batch','like','%'.$req['txtSearch'].'%');
            });
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id'], 'text' => $data['material'].' | '.$data['warna_cones'].' | '.$data['batch'].' | '.$data['tare_cones']);
        }
        
        echo json_encode($ret);
    }
    
//    public function select2tipe(Request $request)
//    {
//        $ret    = array(
//            array('id' => 'KARUNG','text' => 'KARUNG'),
//            array('id' => 'BOX','text' => 'BOX'),
//            array('id' => 'PARCEL','text' => 'PARCEL'),
//            array('id' => 'SISA CONES','text' => 'SISA CONES'),
//            array('id' => 'ACTUAL','text' => 'ACTUAL')
//        );
////        $datas  = array();
////        if($request->input('id'))
////        {
////            $datas = Master::where('id',$request->input('id'))->whereHapus('1')->limit(10);
////        }
////        else
////        {
////            $datas = Master::where('deskripsi',$request->input('id'))->whereHapus('1')->limit(10);
////        }
////        $datas = $datas->get()->toArray();
////        
////        foreach($datas as $data)
////        {
////            $ret[] = array('id' => $data['id'], 'text' => $data['deskripsi'].' | '.$data['packing']);
////        }
//        
//        echo json_encode($ret);
//    }
}
