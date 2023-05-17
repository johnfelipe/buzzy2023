<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>@yield('title', __('Admin Panel'))</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
<link rel="icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet"/>
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/bootstrap-theme.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/dataTables.bootstrap.min.css')}}" rel="stylesheet"/>

@yield('styles')

<link href="{{asset('css/admin.css')}}" rel="stylesheet" />
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

@yield('head')

</head>
<body>
@include('admin._header')

<div class="main clearfix">
    <div class="main-inner">
        <div class="container">
            @yield('content')
        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->
<div id="notifications" style="position:fixed;z-index:10000;bottom:20px;right:20px;width:300px;"></div>
@include('admin._footer')

<!-- /footer -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/admin.js')}}"></script>

<!-- /footer js -->

@yield('footer')

</body>
</html>
