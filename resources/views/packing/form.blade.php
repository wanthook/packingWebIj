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
        
        $("#berat_id").select2({
            delay: 500,
            minimumInputLength: 0,
            ajax: 
            {
                url: "{{ route('berat.select2') }}",
                dataType: 'json',
                type: 'post',                
                data: function (term, page) 
                {                
                    return { q : term  }
                },
                results: function(data, page ) 
                {
//                    $('#berat').val();
//console.log(data);
                    return { results: data }
                }
            },
            initSelection: function(element, callback) 
            {
                var id = jQuery(element).val();

                if(id!="")
                {
                    jQuery.ajax( 
                    {                    
                        url: "{{ route('berat.select2') }}",
                        dataType: 'json',
                        type: 'post',
                        data: {id: id}
                    }).done(function(data){ callback(data[0]);});
                    
                    
                }
            }
        });
        
        $('#berat_id').on("select2-selecting", function(e) { 
            // what you would like to happen
//            console.log(e.choice.berat);
            
            if(typeof e.choice.berat!='undefined')
            {
                $('#berat_material').val(e.choice.berat);
                $('#berat_tipe').val(e.choice.tipe);
                hitungBruto();
            }
            else
            {
                $('#berat_material').val("0");
            }
            
        });
        
        $('#tare_cones,#tare_lain').mask("#,##0.00", 
        {
            reverse: true
        });
        
        $('#tare_cones,#tare_lain').on('keyup',function(e)
        {
            hitungBruto();
        });
    });
    
    var hitungBruto = function()
    {
        var x = parseFloat($('#berat_material').val()) + parseFloat($('#tare_cones').val()) + parseFloat($('#tare_lain').val());
//            console.log(x);
        var tipe = $('#berat_tipe').val();
        if(!isNaN(x) && tipe != "SISA CONES")
        {
            $('#bruto').val(x);
        }
        else
        {
            $('#bruto').val('0');
        }
    }
</script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-dropbox"></i>
                        </span>&nbsp;&nbsp;<a href="{{route('packing.list')}}">List Packing</a>&nbsp;>&nbsp;Form Packing
                    </h4>
                </div>     
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Form Packing Indah Jaya
                        </div>                        
                        @if(!isset($var->id))
                            {!! Form::model($var, ['url' => route('packing.save'),'class' => 'form-horizontal']) !!}
                        @else
                            {!! Form::model($var,['method' => 'PATCH', 'route' => ['packing.change',$var->id],'class' => 'form-horizontal']) !!}
                        @endif
                        <div class="panel-body">
                            
                            {!! form::hidden('id',null,['id' => 'id']) !!}
                            <div class="form-group{{ $errors->has('material')?' has-error':'' }}">
                                <label for="material" class="col-sm-2 control-label">Material *</label>
                                <div class="col-xs-8">
                                    {!! Form::text('material',null,['class' => 'form-control', 'id' => 'material', 'placeholder' => 'Material']) !!}
                                    {!! $errors->first('material','<span class="help-block">:message</span>') !!}
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('warna_cones')?' has-error':'' }}">
                                <label for="warna_cones" class="col-sm-2 control-label">Warna Cones *</label>
                                <div class="col-xs-8">
                                    {!! Form::text('warna_cones',null,['class' => 'form-control', 'id' => 'warna_cones', 'placeholder' => 'Warna Cones', 'maxlength' => '60']) !!}
                                    {!! $errors->first('warna_cones','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('batch')?' has-error':'' }}">
                                <label for="batch" class="col-sm-2 control-label">Batch *</label>
                                <div class="col-xs-4">
                                    {!! Form::text('batch',null,['class' => 'form-control', 'id' => 'batch', 'placeholder' => 'Batch']) !!}
                                    {!! $errors->first('batch','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>                            
                            <div class="form-group{{ $errors->has('Tipe Berat')?' has-error':'' }}">
                                <label for="berat_id" class="col-sm-2 control-label">Tipe Berat *</label>
                                <div class="col-xs-6">
                                    {!! Form::hidden('berat_id',null,['class' => 'form-control', 'id' => 'berat_id']) !!}
                                    {!! $errors->first('berat_id','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>                             
                            <div class="form-group{{ $errors->has('berat_tipe')?' has-error':'' }}">
                                <label for="berat_tipe" class="col-sm-2 control-label">Tipe Berat</label>
                                <div class="col-xs-2">
                                    {!! Form::text('berat_tipe',null,['class' => 'form-control', 'id' => 'berat_tipe', 'placeholder' => 'Tipe Berat','readonly']) !!}
                                    {!! $errors->first('berat_tipe','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>                        
                            <div class="form-group{{ $errors->has('berat_material')?' has-error':'' }}">
                                <label for="berat_material" class="col-sm-2 control-label">Berat</label>
                                <div class="col-xs-2">
                                    {!! Form::text('berat_material',null,['class' => 'form-control', 'id' => 'berat_material', 'placeholder' => 'Berat','readonly']) !!}
                                    {!! $errors->first('berat_material','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('tare_cones')?' has-error':'' }}">
                                <label for="tare_cones" class="col-sm-2 control-label">Tare Cones *</label>
                                <div class="col-xs-2">
                                    {!! Form::text('tare_cones',null,['class' => 'form-control', 'id' => 'tare_cones', 'placeholder' => 'Tare Cones']) !!}
                                    {!! $errors->first('tare_cones','<span class="help-block">:message</span>') !!}
                                </div>
                            </div> 
                            <div class="form-group{{ $errors->has('tare_lain')?' has-error':'' }}">
                                <label for="tare_lain" class="col-sm-2 control-label">Tare Lain</label>
                                <div class="col-xs-2">
                                    {!! Form::text('tare_lain',null,['class' => 'form-control', 'id' => 'tare_lain', 'placeholder' => 'Tare Lain']) !!}
                                    {!! $errors->first('tare_lain','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>                            
                            <div class="form-group{{ $errors->has('bruto')?' has-error':'' }}">
                                <label for="bruto" class="col-sm-2 control-label">Bruto</label>
                                <div class="col-xs-2">
                                    {!! Form::text('bruto',null,['class' => 'form-control', 'id' => 'bruto', 'placeholder' => 'Bruto','readonly']) !!}
                                    {!! $errors->first('bruto','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>Simpan</button>
                            <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i>Reset</button>
                            {!! Form::close() !!}
                            <a href="{{route('packing.list')}}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>Kembali</a>
                        </div>
                        
                    </div>                     
                </div>
            </div>
        </div>
@endsection