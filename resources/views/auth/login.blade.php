@extends('layouts.sb2')

@section('additional_style')
<style>
body 
{
    background: url({{asset('/assets/images/background.jpg')}}) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
</style>
@endsection

@section('additional_js')
@endsection

@section('nav_content')
@endsection

@section('body_content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Silakan Login</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('url' => route('login'),'class' => 'stdform')) !!}
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            <!--<a class="btn btn-lg btn-success btn-block">Login</a>-->
                        </fieldset>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('dibuatoleh')
                    <p class="navbar-text">Dibuat oleh: Taufiq Hari Widodo (Ext. 383) | Laravel {{ App::VERSION() }}</p>
@endsection