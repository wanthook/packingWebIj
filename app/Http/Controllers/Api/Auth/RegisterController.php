<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Routing\Route;
//use Illuminate\Routing\R;

class RegisterController extends Controller
{
    
    private $client;
    
    public function __construct() 
    {
        $this->client = Client::find(1);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'name'      => 'required',
            'username'  => 'required|unique:users',
            'email'     => 'email',
            'password'  => 'required|min:3|confirmed'
        ]);
        
        $user = User::create([
            'name'  => request('name'),
            'username'  => request('username'),
            'email'     => request('email'),
            'password'  => bcrypt(request('password')),
            'photo'     => request('photo'),
            'ttd_img'   => request('ttd_img'),
            'type'      => request('type'),
        ]);
        
//        $params = [
//            'grant_type'        => 'password',
//            'client_id'         => $this->client->id,
//            'client_secret'     => $this->client->secret,
//            'username'          => request('username'),
//            'password'          => request('password'),
//            'scope'             => '*'
//        ];
//        
//        $request->request->add($params);
        
        $proxy = Request::create("oauth/token","POST");
        
        return $proxy;
//        return Illuminat
        
//        dd($request->all());
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
