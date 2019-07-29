<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Timbangan as Master;
use App\User as Users;
use App\Download as Download;
use Auth;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Storage;

class TimbanganController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('timbangan.list');
    }
    
    public function indexDownload()
    {
        return view('timbangan.listDownload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $var = new Master;
        
        return view('timbangan.form',compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    
    public function saveData()
    {
        $data = null;
        
        $jumlahData = 0;
        
//        if(empty($id))
//        {
        $data = Master::where('hapus',1)
                      ->where('download_id',null)
                      ->orderBy('material','ASC')
                      ->orderBy('batch','ASC')
                      ->orderBy('mill','ASC')
                      ->orderBy('deskripsi','ASC')
                      ->orderBy('no','ASC');
//            echo $data->count();
        $tData = $data->count();
        $sData = 1;

        if($tData > 0)
        {
            $mat = "";
            $bat = "";
            $mil = "";
            $pak = "";

//                $connection = ssh2_connect('10.10.55.6', 22);
//                ssh2_auth_password($connection, 'admin', 'spinmill');

            $row = $data->get();

            $str = "";

            foreach($row as $k => $v)
            {
                $berat = 0;
                if($v->berat_sc>0)
                {
                    $berat = $v->berat_sc;
                }
                else
                {
                    if($v->tipe_berat == "ACTUAL")
                    {
                        $berat = $v->actual;
                    }
                    else
                    {
                        $berat = $v->standar;
                    }
                }

                if(empty($mat) && empty($bat) && empty($mil) && empty($pak))
                {
                    $mat = $v->material;
                    $bat = $v->batch;
                    $mil = $v->mill;
                    $pak = $v->deskripsi;

                    $str = $v->material ."\t".
                            $v->batch."\t".
                            sprintf("%010d",$v->no)."\t".
                            ($berat+($v->tare_cones + $v->tare_lain))."\t".
                            ($v->tare_cones + $v->tare_lain)."\t".
                            $v->warna_cones."\t".
                            $v->mill."\t".
                            $v->deskripsi."\t".
                            ($v->palet_id==""?"0":$v->palet_id)."\r\n";

                    $jumlahData++;
                }
                else
                {
                    if($mat!=$v->material || $bat!=$v->batch || $mil!=$v->mill || $pak!=$v->deskripsi || $sData==$tData)
                    {
                        if($sData==$tData)
                        {
                            $str .= $v->material ."\t".
                                $v->batch."\t".
                                sprintf("%010d",$v->no)."\t".
                                ($berat+($v->tare_cones + $v->tare_lain))."\t".
                                ($v->tare_cones + $v->tare_lain)."\t".
                                $v->warna_cones."\t".
                                $v->mill."\t".
                                $v->deskripsi."\t".
                                ($v->palet_id==""?"0":$v->palet_id)."\r\n";
                            $jumlahData++;
                        }
                        $filename = str_replace('/', '-', $mat).'_'.$bat.'_'.$mil.'_'.str_replace('/', '-', $pak).'.txt';

                        $file = fopen("/mnt/server_file/document_packing/".$filename,"a+");
//                        $file = fopen("/home/wanthook/Documents/1010557/".$filename,"a+");
                        fwrite($file, $str);
                        fclose($file);

                        //Storage::append("fileupload/".$filename, $str);
                        
                        $dataDownload = Download::where('nama_file',$filename)->first();
                        
                        if($dataDownload)
                        {
                                
                                Master::where('hapus',1)
                                        ->where('download_id',null)
                                        ->where('material',$mat)
                                        ->where('batch', $bat)
                                        ->where('mill', $mil)
                                        ->where('deskripsi', $pak)->update(['download_id'=>$dataDownload->id]);
                            
                                $dataDownload->jumlah_data = ($dataDownload->jumlah_data+$jumlahData);
                                $dataDownload->save();
                        }
                        else
                        {
                        
                            $saveFile = array(
                                'tanggal_unduh' => Carbon::now()->toDateTimeString(),
                                'nama_file' => $filename,
                                'jumlah_data' => $jumlahData,
                                'created_by' => Auth::user()->id,
                                'created_at' => Carbon::now()
                            );

                            $save = Download::create($saveFile);
                            
                            Master::where('hapus',1)
                                              ->where('download_id',null)
                                              ->where('material',$mat)
                                              ->where('batch', $bat)
                                              ->where('mill', $mil)
                                              ->where('deskripsi', $pak)->update(['download_id'=>$save->id]);
                        }
                        
                        if($tData!=$sData)
                        {
                            $mat = $v->material;
                            $bat = $v->batch;
                            $mil = $v->mill;
                            $pak = $v->deskripsi;
                            $jumlahData = 0;

                            $str = $v->material ."\t".
                                $v->batch."\t".
                                sprintf("%010d",$v->no)."\t".
                                ($berat+($v->tare_cones + $v->tare_lain))."\t".
                                ($v->tare_cones + $v->tare_lain)."\t".
                                $v->warna_cones."\t".
                                $v->mill."\t".
                                $v->deskripsi."\t".
                                ($v->palet_id==""?"0":$v->palet_id)."\r\n";
                            $jumlahData++;
                        }
                    }
                    else
                    {
                        $str .= $v->material ."\t".
                            $v->batch."\t".
                            sprintf("%010d",$v->no)."\t".
                            ($berat+($v->tare_cones + $v->tare_lain))."\t".
                            ($v->tare_cones + $v->tare_lain)."\t".
                            $v->warna_cones."\t".
                            $v->mill."\t".
                            $v->deskripsi."\t".
                            ($v->palet_id==""?"0":$v->palet_id)."\r\n";

                        $jumlahData++;
                    }
                }

                $sData++;
            }
            redirect()->route('timbangan.listDownload')->with("msg","Data berhasil di-download ke server 10.10.55.6/downloadpacking");
        }
        else
        {
            return redirect()->route('timbangan.listDownload')->with("msg","Tidak ada data yang di-download. Karena semua sudah di-download.");
        }
//        }
        return redirect()->route('timbangan.listDownload')->with("msg","Tidak ada data yang di-download. Karena semua sudah di-download.");
    }
    
    public function downloadData($id="")
    {
        $data = null;
        if(empty($id))
        {
            $data = Master::where('hapus',1)->where('download_id',null);
        }
        else
        {
            $data = Master::where('hapus',1)->where('download_id',$id);
        }
        
        
        $totalData = $data->count();
        
        if($totalData>0)
        {
            $timbangan = $data->orderBy('material','ASC')->orderBy('batch','ASC')->orderBy('no','ASC')->get();
            
            $str = "";
            
            foreach($timbangan as $k => $v)
            {
                $berat = 0;
                if($v->berat_sc>0)
                {
                    $berat = $v->berat_sc;
                }
                else
                {
                    $berat = $v->standar;
                }
                
                $str .= $v->material ."\t".
                        $v->batch."\t".
                        sprintf("%010d",$v->no)."\t".
                        ($berat+($v->tare_cones + $v->tare_lain))."\t".
                        ($v->tare_cones + $v->tare_lain)."\t".
                        $v->warna_cones."\t".
                        $v->mill."\t".
                        $v->deskripsi."\t".
                        ($v->palet_id==""?"0":$v->palet_id)."\r\n";
            }
//            echo $str;
            if(empty($id))
            {
                $palets = array(
                    'tanggal_unduh' => Carbon::now()->toDateTimeString(),
                    'jumlah_data' => $totalData,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                );

                $save = Download::create($palets);
                $data->update(array('download_id' => $save->id));
            }
            
            
            return response()->attachment($str);
//            redirect()->route('timbangan.listDownload')->with("msg","Data berhasil di-download.");
        }
        
        return redirect()->route('timbangan.listDownload')->with("msg","Tidak ada data yang di-download. Karena semua sudah di-download.");
    }
    
    public function dataTables(Request $request)
    {
        $req    = $request->all();
        
        $datas   = Master::with(['createduser','packing'])->where('hapus',1);  
//        print_r($datas->first());
        if(!empty($req['txtMaterial']))
        {
            $datas->where('material','like','%'.$req['txtMaterial'].'%');
        }
        
        if(!empty($req['txtBatch']))
        {
            $datas->where('batch','like','%'.$req['txtBatch'].'%');
        }
        
        if(!empty($req['txtMill']))
        {
            $datas->where('mill', $req['txtMill']);
        }
        
        $datas->orderBy('id','desc');
        
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str    = "";
//                    $str    .= '<a href="'.route("timbangan.ubah",$datas->id).'" class="editrow btn btn-default" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
                    
                    return $str;
                })
                ->addColumn('no',function($datas)
                {
                    return sprintf("%010d",$datas->no);
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
    public function dataTablesDownload(Request $request)
    {
        $req    = $request->all();
        
        $datas   = Download::with(['createduser'])->where('hapus',1);  
//        print_r($datas->first());
        if(!empty($req['txtSearch']))
        {
//            $datas->where('deskripsi','like','%'.$req['txtSearch'].'%');
            $datas->whereHas('timbangan',function($q) use($req)
            {
                $q->where('material','like','%'.$req['txtSearch'].'%');
                $q->orWhere('warna_cones','like','%'.$req['txtSearch'].'%');
                $q->orWhere('batch','like','%'.$req['txtSearch'].'%');
            });
        }
        
        $datas->orderBy('id','desc');
        
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str    = "";
                    if(Auth::user()->type == "ADMIN")
                    {
                        $str    .= '<a target="_blank" href="'.route('timbangan.redownload',$datas->nama_file).'" class="editrow btn btn-success" title="Download"><i class="fa fa-download"></i></a>&nbsp;';
                    }
//                    $str    .= '<a href="'.route("timbangan.ubah",$datas->id).'" class="editrow btn btn-default" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
                    
                    return $str;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
}
