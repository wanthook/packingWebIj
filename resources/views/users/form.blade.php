@extends('sb2.admsb2')

@section('additional_style')
<!-- datetimepicker bootstrap CSS -->
<link href="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
<!--typeahead -->
<link href="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.css')}}" rel="stylesheet">
<!-- Select2 CSS -->
<link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.css')}}" rel="stylesheet">
<link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2-bootstrap.css')}}" rel="stylesheet">
<!-- DataTables CSS -->
<link href="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
<!-- DataTables Responsive CSS -->
<link href="{{asset('/assets/sb2/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
<style>
    th, td { white-space: nowrap; }
        div.dataTables_wrapper {
            width: 100%;   
            font-size: 10pt;
        }
</style>
@endsection

@section('additional_js') 
<!-- DataTables Plugin JavaScript -->
    <script src="{{asset('/assets/sb2/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/mathjs/dist/math.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>
<script>
    var table = null;
    var i = {{count(Form::old('detail'))}};
    $(document).ready(function()
    {
        $.ajaxSetup({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
        });
        math.config({
            number: 'number' // Default type of number: 
                             // 'number' (default), 'BigNumber', or 'Fraction'
        });
    });
</script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-shopping-cart"></i>
                        </span>&nbsp;&nbsp;<a href="{{route('user.list')}}">List User</a>&nbsp;>&nbsp;Form User
                    </h4>
                </div>     
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form User
                        </div>                        
                        @if(!isset($var->id))
                            {!! Form::model($var, ['url' => route('user.save'),'class' => 'form-horizontal', 'files' => true]) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['user.change',$var->id],'class' => 'form-horizontal', 'files' => true]) !!}
                        @endif
                        <div class="panel-body">
                            {!! form::hidden('id',null,['id' => 'id']) !!}
                            <div class="form-group{{ $errors->has('photo')?' has-error':'' }}">
                                <label for="photo" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-xs-5">
                                    @if(isset($var->photo))
                                        @if(!empty($var->photo))
                                        <img src="{{route('user.pht',$var->photo)}}">
                                        @else
                                        <img src="{{asset("/assets/images/polos.png")}}" style="width:100px;height:100px;" class="pht">
                                        @endif
                                    @else
                                    <img src="{{asset("/assets/images/polos.png")}}" style="width:100px;height:100px;" class="pht">
                                    @endif
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('photo')?' has-error':'' }}">
                                <label for="photo" class="col-sm-2 control-label">Photo</label>
                                <div class="col-xs-5">
                                {!! Form::file('photo') !!}
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('username')?' has-error':'' }}">
                                <label for="username" class="col-sm-2 control-label">Username *</label>
                                <div class="col-xs-5">
                                    {!! Form::text('username',null,['class' => 'form-control', 'id' => 'username']) !!}
                                    {!! $errors->first('username','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password')?' has-error':'' }}">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-xs-3">
                                    {!! Form::password('password',null,['class' => 'form-control', 'id' => 'password']) !!}                                    
                                    {!! $errors->first('password','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('type')?' has-error':'' }}">
                                <label for="type" class="col-sm-2 control-label">Tipe</label>
                                <div class="col-xs-5">
                                    {!! Form::select('type', ['MACHINE'=>'MACHINE',
                                                              'ADM' => 'ADM',
                                                              'ADMIN'=>'ADMIN']) !!}
                                    {!! $errors->first('type','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sebutan')?' has-error':'' }}">
                                <label for="sebutan" class="col-sm-2 control-label">Sebutan</label>
                                <div class="col-xs-5">
                                    {!! Form::select('sebutan', [''=>'Silakan Pilih','Mr' => 'Mr', 'Mrs' => 'Mrs', 'Ms'=>'Ms']) !!}
                                    {!! $errors->first('sebutan','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name')?' has-error':'' }}">
                                <label for="name" class="col-sm-2 control-label">Nama *</label>
                                <div class="col-xs-5">
                                    {!! Form::text('name',null,['class' => 'form-control', 'id' => 'name']) !!}
                                    {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email')?' has-error':'' }}">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-xs-5">
                                    {!! Form::text('email',null,['class' => 'form-control', 'id' => 'email']) !!}
                                    {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('ttd_img')?' has-error':'' }}">
                                <label for="ttd_img" class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-xs-5">
                                    @if(isset($var->ttd_img))
                                        @if(!empty($var->ttd_img))
                                        <img src="{{route('user.ttd',$var->ttd_img)}}">
                                        @else
                                        <img src="{{asset("/assets/images/upload.png")}}" style="width:100px;height:100px;" class="ttd">
                                        @endif
                                    @else
                                    <img src="{{asset("/assets/images/upload.png")}}" style="width:100px;height:100px;" class="ttd">
                                    @endif
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('ttd_img')?' has-error':'' }}">
                                <label for="ttd_img" class="col-sm-2 control-label">Tanda Tangan</label>
                                <div class="col-xs-5">
                                    {!! Form::file('ttd_img') !!}
                                </div>
                            </div> 
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>Simpan</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Reset</button>
                            {!! Form::close() !!}
                            <a href="{{route('home.root')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Kembali</a>
                        </div>
                        
                    </div>                     
                </div>
            </div>
        </div>
@endsection