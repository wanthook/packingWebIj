@extends('sb2.admsb2')

@section('additional_style')
    <!-- DataTables CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('/assets/sb2/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/sb2/bower_components/select2-3.5.4/select2-bootstrap.css')}}" rel="stylesheet">
    <!-- datetimepicker bootstrap CSS -->
    <link href="{{asset('/assets/sb2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
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
        });
    </script>
@endsection

@section('body_content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12"> 
                    <h4 class="page-header">
                        <span class="btn btn-warning btn-circle btn-lg">
                            <i class="fa fa-dashboard"></i>
                        </span>&nbsp;&nbsp;Dashboard
                    </h4>
                </div>                
                <!-- /.col-lg-12 -->
            </div>
            @if(session('msg'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('msg') }}
                </div>
            @endif
        </div>
@endsection
