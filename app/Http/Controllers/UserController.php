<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Http\Requests;

use App\Http\Controllers\Controller;
//use App\Http\Requests\CreateUserRequest;
use App\User as Users;
//use App\Plant as Plant;
use Auth;
use Yajra\DataTables\DataTables;
/**
 * Description of Users
 *
 * @author wanthook
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
//        echo Route::getFacadeRoot()->current()->getName();
        return view('users.list');
    }
    
    public function add()
    {
        $var = new Users;
                
        return view('users.form',compact('var'));
    }
    
    public function save(Request $request)
    {
        $data   = $request->all();
        
        $msg    = "";
        
        if(isset($data['photo']))
        {
            if ($data['photo']->isValid()) 
            {
                $filename = crc32($data['photo']->getClientOriginalName());
                $data['photo']->move(storage_path('uploads/profiles/'), $filename);
                $data['photo'] = $filename;
            }
        }
        
        if(isset($data['ttd_img']))
        {
            if ($data['ttd_img']->isValid()) 
            {
                $filename = crc32($data['ttd_img']->getClientOriginalName());
                $data['ttd_img']->move(storage_path('uploads/ttd/'), $filename);
                $data['ttd_img'] = $filename;
            }
        }
        
        if(!empty($data['password']))
        {
            $data['password']  = bcrypt($data['password']);
        }
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        
        $save = Users::create($data);
        if($save->id)
        {
//            $plant = $this->savePlant($save->id, $data['plant']);
            $msg = "Data berhasil disimpan";
        }
        else
        {
            $msg = "Data gagal disimpan";
        }
        
        return redirect()->route('user.list')->with("msg",$msg);
    }
    
    public function changepass($id,Request $request)
    {
        $req = $request->all();
        $route = Route::getFacadeRoot()->current()->getName();
        $msg = "";
        
        if(isset($req['old_password']))
        {
            if(password_verify($req['old_password'], Auth::user()->password))
            {
                if(isset($req['new_password']) && isset($req['retype_password']))
                {
                    if(!empty($req['new_password']) && !empty($req['retype_password']))
                    {
                        $edit = Users::whereId($id)->first();
                        $req['password']   = bcrypt($req['new_password']);
                        $req['updated_by'] = Auth::user()->id;
                        $req['updated_at'] = Carbon::now();
                        
                        $edit->fill($req)->save();
                        
                        $msg = "Password berhasil diubah.";
                    }
                    else
                    {
                        $msg = "Password baru tidak boleh kosong.";
                    }
                }
            }
            else
            {
                $msg = "Password tidak sama";
            }
            
        }
        return redirect()->route("home.root")->with("msg",$msg);
        
    }
    
    public function dataTables(Request $request)
    {
        $req    = $request->all();
        
        $datas   = Users::where('hapus',1);  
        $datas->orderBy('id','asc');
        
        return  Datatables::of($datas)
                ->addColumn('action',function($datas)
                {
                    $str  = '<a href="'.route("user.ubah",$datas->id).'" class="editrow btn btn-default"><i class="fa fa-edit"></i></a>&nbsp;';
                    
                    return $str;
                })
                ->addColumn('pht',function($datas)
                {
                    if(!empty($datas->photo))
                    {
                        $str  = "<a target=\"_blank\" href=\"".route('user.pht',$datas->photo)."\"><img src=\"".route('user.pht',$datas->photo)."\" style=\"width:50px;height:50px;\" class=\"pht\"></a>";
                    
                        return $str;
                    }
                    else
                        return "";
                })
                ->addColumn('ttd',function($datas)
                {
                    if(!empty($datas->ttd_img))
                    {
                        return '<a target="_blank" href="'.route('user.ttd',$datas->ttd_img).'"><img src="'.route('user.ttd',$datas->ttd_img).'" style="width:50px;height:50px;" class="ttd"></a>';
                    }
                    else
                        return "";
                })
                ->rawColumns(['action', 'pht'])
//                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
    
//    private function savePlant($userId,$plantId)
//    {
//       $usr = Users::whereId($userId)->first();
//        
//        $plant = explode(',',$plantId);
//        
//        $usr->plant()->detach();
//        
//        $usr->plant()->attach($plant);
//        
//    }
}
