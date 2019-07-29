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
<script src="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
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
                    "url"       : "{{ route('user.tabel') }}",
                    "type"      : 'POST',
                    data: function (d) 
                    {
                        d.txtSearch     = $('#txtSearch').val();
                    }
                },
                "columns"           :
                [
                    { data    : "action", name: "action", orderable: false, searchable: false},
                    {
                        "data":function( row )
                        {
                            var str = "";
                            if(row.pht)
                            {
                                str += row.pht;
                            }
                            return str;
                        }
                    },
                    { data    : "username", name: "username" },
//                    { data    : "sebutan", name: "sebutan" },
                    { data    : "name", name: "name" },
                    { data    : "email", name: "email" },
                    {
                        "data":function( row )
                        {
                            var str = "";
                            if(row.ttd)
                            {
                                str += row.ttd;
                            }
//                            else
//                            {
//                                str += '<img src="{{asset("/assets/images/upload.png")}}" style="width:50px;height:50px;" class="img">';
//                            }
                            return str;
    //                        return '<input type="text" name="detail['+i+'][pemohon_pin]" id="pemohon_pin'+i+'" class="form-control pemohon_pin" placeholder="Pemohon Pin" value="'+row.pemohon_pin+'">';
                        }
                    },
                    { data    : "type", name: "type" }

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
                            <i class="fa fa-user"></i>
                        </span>&nbsp;&nbsp;Users
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            List Users
                        </div>
                        
                        <div class="panel-body">  
                            <div class="pull-left form-inline">
                                {!! Form::text('txtSearch',null,['class' => 'form-control input-sm', 'id' => 'txtSearch', 'placeholder' => 'PIN/Nama Users']) !!}
                                <button class="btn btn-primary btn-sm" id="btnSearch"><i class="fa fa-search"></i></button>
                            </div>
                            @if(Auth::user()->type == "ADMIN")
                            <div class="pull-right">
                                <a href="{{route('user.add')}}" class="btn btn-success btn-sm"><i class="fa fa-plus-square "></i> Tambah User</a>
                            </div>  
                            @endif
                        </div>
                        
                        <div class="table-responsive">
                            <table width="100%" id="tableId" class="table table-striped table-hover">
                                @php
                                $arrHead = array('Action',
                                                 'Photo',
                                                 'Username',
                                                 'Nama',
                                                 'Email',
                                                 'Tanda Tangan',
                                                 'Tipe User'
                                                 );
                                @endphp
                                <thead>
                                    <tr>
                                        @php  
                                        $col = 0;
                                        @endphp
                                        @for ($i = 0; $i < count($arrHead); $i++)
                                            <th class="head{{$col}}">{{$arrHead[$i]}}</th>
                                            @if($col==0) 
                                                @php 
                                                    $col = 1;
                                                @endphp
                                            @else
                                                @php 
                                                $col = 0;
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