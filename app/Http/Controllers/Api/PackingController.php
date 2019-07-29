<?php

namespace App\Http\Controllers\Api;

use App\Packing as Master;
use App\Palet as Palet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;
use Carbon\Carbon;

class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Master::with(['berat'])->where('hapus',1);
        
        if(!empty(request('material')))
        {
            $data->where('material','like','%'.request('material').'%');
        }    
        
        if(!empty(request('batch')))
        {
            $data->where('batch','like','%'.request('batch').'%');
        }   
        
//        if(!empty(request('tipe_berat')) && request('tipe_berat')!="null")
//        {
//            $data->where('tipe_berat','like','%'.request('tipe_berat').'%');
//        } 
        
        $data->limit(100);
        $data->orderBy('id','desc');
        
        return Fractal::includes('packing')->collection($data->get(), new \App\Transformers\PackingTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
