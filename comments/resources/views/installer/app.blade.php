<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>@yield('title', env('APP_NAME'))</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon"/>
<link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet"/>
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/admin.css')}}" rel="stylesheet" />
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

@yield('head')
</head>
<body id="js-content" class="@yield('body_class')">

@include('auth._header')

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

<!-- /footer -->
<div id="notifications" style="position:fixed;z-index:10000;bottom:20px;right:20px;width:300px;"></div>

<!-- /footer -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/admin.js')}}"></script>

@yield('footer')

</body>
</html>
