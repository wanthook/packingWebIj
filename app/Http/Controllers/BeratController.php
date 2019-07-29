<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use App\Berat as Master;
use Yajra\DataTables\DataTables;

class BeratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('berat.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $var = new Master;
        
        return view('berat.form',compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'deskripsi'      => 'required',
            'tipe'  => 'required',
            'berat'     => 'required',
        ],[
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'tipe.required'  => 'Tipe berat harus diisi.',
            'berat.required'  => 'Berat harus diisi.',
        ]);
        $data   = $request->all();
        
        $data['deskripsi'] = strtoupper($data['deskripsi']);
        $data['berat'] = str_replace(",", "", $data['berat']);
        $data['created_by'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        $data['updated_by'] = Auth::user()->id;
        $data['updated_at'] = Carbon::now();
        
        $save = Master::create($data);
        return redirect()->route('berat.list')->with("msg","Data berhasil disimpan");
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
        $var = Master::where('id',$id)->first();
        
        return view('berat.form',compact('var'));
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
        $this->validate($request, [
            'deskripsi'      => 'required',
            'tipe'  => 'required',
            'berat'     => 'required',
        ],[
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'tipe.required'  => 'Tipe berat harus diisi.',
            'berat.required'  => 'Berat harus diisi.',
        ]);
        $data   = $request->all();
        
        $edit = Master::where('id',$id)->first();
        $data['deskripsi'] = strtoupper($data['deskripsi']);
        $data['berat'] = str_replace(",", "", $data['berat']);
        $data['updated_by'] = Auth::user()->id;
        $data['updated_at'] = Carbon::now();
        
        $edit->fill($data)->save();
        
        return redirect()->route('berat.list')->with("msg","Data berhasil diubah");
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
    
    public function dataTables(Request $request)
    {
        $req    = $request->all();
        
        $datas   = Master::with(['createduser'])->where('hapus',1);  
//        print_r($datas->first());
        if(!empty($req['txtSearch']))
        {
            $datas->where('deskripsi','like','%'.$req['txtSearch'].'%');
        }
        if(!empty($req['txtTipe']))
        {
            $datas->where('tipe',$req['txtTipe']);
        }
        $datas->orderBy('id','desc');
        
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str    = "";
                    $str    .= '<a href="'.route("berat.ubah",$datas->id).'" class="editrow btn btn-default" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
                    
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
            $datas = Master::where('deskripsi','like','%'.$request->input('q').'%')->whereHapus('1')->limit(10);
        }
        $datas = $datas->get()->toArray();
        
        foreach($datas as $data)
        {
            $ret[] = array('id' => $data['id'], 'text' => $data['deskripsi'].' | '.$data['berat'], 'berat' => $data['berat'], 'tipe' => $data['tipe']);
        }
        
        echo json_encode($ret);
    }
}   
