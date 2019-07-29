@extends('sb2.admsb2')

@section('additional_style')
    <!-- datetimepicker bootstrap CSS -->
    <link href="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
        <!-- Select2 CSS -->
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2-bootstrap.css')}}" rel="stylesheet">
    <!--typeahead -->
    <link href="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.css')}}" rel="stylesheet">
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
    <script src="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('/assets/sb2/bower_components/typeahead.js/dist/typeahead.bundle.min.js')}}"></script>
    <script>
        var dataTable = null;
        $(document).ready(function(e)
        {
            $.ajaxSetup({
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'}
            });
            
            $('#btnSearch').on('click',function(e)
            {
                dataTable.ajax.reload();
            });
            
            $("#txtMill").select2({
                delay: 500,
                minimumInputLength: 0,
                ajax: 
                {
                    url: "{{ route('mesin.select2') }}",
                    dataType: 'json',
                    type: 'post',                
                    data: function (term, page) 
                    {                
                        return { q : term  }
                    },
                    results: function(data, page ) 
                    {
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
                            url: "{{ route('mesin.select2') }}",
                            dataType: 'json',
                            type: 'post',
                            data: {id: id}
                        }).done(function(data){ callback(data[0]);});


                    }
                }
            });
            
            dataTable = $('#tableId').DataTable({
                "sPaginationType": "full_numbers",
                "searching":false,
                "ordering": true,
                "scrollY": 400,
                "scrollX": true,
                "deferRender": true,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [100, 500, 1000, 1500, 2000 ],
                "ajax":
                {
                    "url"       : "{{ route('timbangan.tabel') }}",
                    "type"      : 'POST',
                    data: function (d) 
                    {
                        d.txtMaterial     = $('#txtMaterial').val();
                        d.txtBatch        = $('#txtBatch').val();
                        d.txtMill         = $('#txtMill').val();
                    }
                },
                "columns"           :
                [
                    { data    : "action", name: "action", orderable: false, searchable: false},
                    { data    : "no", name: "no" },
                    { data    : "material", name: "material" },
                    { data    : "warna_cones", name: "warna_cones" },
                    { data    : "batch", name: "batch" },
                    { data    : "mill", name: "mill" },
                    { data    : "tare_cones", name: "tare_cones" },
                    { data    : "tare_lain", name: "tare_lain" },
                    { data    : "tipe_berat", name: "tipe_berat" },
                    { data    : "deskripsi", name: "deskripsi" },
                    { data    : "qty", name: "qty" },
                    { data    : "standar", name: "standar" },
                    { data    : "actual", name: "actual" },
                    { data    : "berat_sc", name: "berat_sc" },
                    { data    : "berat_papan", name: "berat_papan" },
                    { data    : "createduser.name", name: "createduser" },
                    { data    : "created_at", name: "created_at" }              

                ],
                "drawCallback": function( settings, json ) 
                {
                    $('.deleterow').on('click',function(e){
                        e.preventDefault();
                        var _this	= jQuery(this);
                        if(confirm('Apakah Anda yakin menghapus data ini?'))
                        {
                            var url = jQuery(this).attr('href');
                            $.ajax({
                                url: url,
                                type: 'POST',
                                dataType: 'json',
                                data: {_method: 'PATCH'}
                            }).success(function (data) {
                                if(data.status==1)
                                {
                                    _this.parents('tr').fadeOut(function(){
                                        _this.remove();
                                    });
                               }
                               else
                               {
                                }
                            });
                        }

                        return false;
                    });
                }
            });
        });
    </script>
@endsection

@section('alert_content')
<div id="ajaxMsg"></div>
@if(session('msg'))
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('msg') }}
    </div>
@endif
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-desktop"></i>
                        </span>&nbsp;&nbsp;List Timbangan
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            List Timbangan                           
                        </div>
                        
                        <div class="panel-body">  
                            <div class="pull-left form-inline">
                                {!! Form::text('txtMaterial',null,['class' => 'form-control input-sm', 'id' => 'txtMaterial', 'placeholder' => 'Material']) !!}
                                {!! Form::text('txtBatch',null,['class' => 'form-control input-sm', 'id' => 'txtBatch', 'placeholder' => 'Batch/LOT']) !!}
                                {!! Form::hidden('txtMill',null,['id' => 'txtMill','style' => 'width:100px;']) !!}
                                <button class="btn btn-primary btn-sm" id="btnSearch"><i class="fa fa-search"></i></button>
                            </div>
                            @if(Auth::user()->type == "ADMIN" || Auth::user()->type == "ADM")
                            <div class="pull-right">
                                <!--<a href="{{route('timbangan.add')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square "></i> Tambah Timbangan</a>-->
                            </div>  
                            @endif
                        </div>
                        
                        <div class="table-responsive">
                            <table width="100%" id="tableId" class="table table-striped table-hover">
                                @php
                                $arrHead = array('Action',
                                                 'No',
                                                 'Material',
                                                 'Warna Cones',
                                                 'Batch',
                                                 'mill',
                                                 'Tare Cones',
                                                 'Tare Lain',
                                                 'Tipe Berat',
                                                 'Deskripsi',
                                                 'QTY (Pcs)',
                                                 'Standar',
                                                 'Aktual',
                                                 'Berat SC',
                                                 'Berat Papan',
                                                 'Dibuat Oleh',
                                                 'Tanggal Buat'
                                                 );
                                $col = 0;
                                @endphp
                                <thead>
                                    <tr>
                                        @for ($i = 0; $i < count($arrHead); $i++)
                                            <th class="head{{$col}}">{{$arrHead[$i]}}</th>
                                            @if($col==0) 
                                                @php
                                                $col = 1 
                                                @endphp
                                            @else
                                                @php
                                                $col = 0 
                                                @endphp
                                            @endif
                                        @endfor  
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
@endsection