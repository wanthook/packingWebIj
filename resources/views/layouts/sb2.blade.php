<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/ico" href="{{asset('favicon.ico')}}"/>
    <title>Aplikasi Packing - Indah Jaya Textile Industry, PT.</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('/assets/sb2/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('/assets/sb2/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">
    
    @yield('additional_style')
    
    <!-- Custom CSS -->
    <link href="{{asset('/assets/sb2/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('/assets/sb2/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    
    <style>
        body { padding-bottom: 70px; }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="wrapper">
        @yield('alert_content')
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand">
                    <img alt="Brand" src="{{asset('assets/images/brand.png')}}">
                </div>
            </div>
            @yield('nav_content')
        </nav>
        @yield('modal_content')
        @yield('body_content')  
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                @yield('dibuatoleh')
                <p class="navbar-text navbar-right">Copyright &copy; 2017, Indah Jaya Textile Industry, PT.</p>
            </div>
        </nav>
</div>
<!-- jQuery -->
    <script src="{{asset('/assets/sb2/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('/assets/sb2/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('/assets/sb2/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{asset('/assets/sb2/dist/js/sb-admin-2.js')}}"></script>
    
    @yield('additional_js')
</body>

</html>
