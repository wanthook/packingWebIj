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
<script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<!--<script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>-->
<!--<script src="{{asset('/assets/sb2/bower_components/mathjs/dist/math.min.js')}}"></script>-->
<script src="{{asset('/assets/sb2/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js')}}"></script>
<script>
    $(document).ready(function()
    {
        $.ajaxSetup({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
        });
        $("#tipe").select2({
            data:
            [
                {id:'KARUNG',text:'KARUNG'},
                {id:'BOX',text:'BOX'},
                {id:'PARCEL',text:'PARCEL'},
                {id:'SISA CONES',text:'SISA CONES'},
                {id:'SAMPLE',text:'SAMPLE'},
                {id:'ACTUAL',text:'ACTUAL'}
            ],
            placeholder : "Tipe Berat"
        });
        
        $('#berat').mask("#,##0.00", 
        {
            reverse: true
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
                        </span>&nbsp;&nbsp;<a href="{{route('berat.list')}}">List Berat</a>&nbsp;>&nbsp;Form Berat
                    </h4>
                </div>     
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Berat Indah Jaya
                        </div>                        
                        @if(!isset($var->id))
                            {!! Form::model($var, ['url' => route('berat.save'),'class' => 'form-horizontal']) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['berat.change',$var->id],'class' => 'form-horizontal']) !!}
                        @endif
                        <div class="panel-body">
                            
                            {!! form::hidden('id',null,['id' => 'id']) !!}
                            <div class="form-group{{ $errors->has('deskripsi')?' has-error':'' }}">
                                <label for="deskripsi" class="col-sm-2 control-label">Deskripsi *</label>
                                <div class="col-xs-8">
                                    {!! Form::text('deskripsi',null,['class' => 'form-control', 'id' => 'deskripsi', 'placeholder' => 'Deskripsi']) !!}
                                    {!! $errors->first('deskripsi','<span class="help-block">:message</span>') !!}
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('tipe')?' has-error':'' }}">
                                <label for="tipe" class="col-sm-2 control-label">Tipe Berat *</label>
                                <div class="col-xs-4">
                                    {!! Form::hidden('tipe',null,['class' => 'form-control', 'id' => 'tipe']) !!}
                                    {!! $errors->first('tipe','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('berat')?' has-error':'' }}">
                                <label for="berat" class="col-sm-2 control-label">Berat *</label>
                                <div class="col-xs-2">
                                    {!! Form::text('berat',null,['class' => 'form-control', 'id' => 'berat', 'placeholder' => 'Berat']) !!}
                                    {!! $errors->first('berat','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>Simpan</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Reset</button>
                            {!! Form::close() !!}
                            <a href="{{route('berat.list')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Kembali</a>
                        </div>
                        
                    </div>                     
                </div>
            </div>
        </div>
@endsection