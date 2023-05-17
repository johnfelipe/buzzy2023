<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet"/>
    @php($theme = isset($theme) ? $theme : env('APP_THEME', 'Default'))
    <link rel="stylesheet" type="text/css" href="{{asset('themes/'.$theme.'/main.css')}}">

    @yield('head')

    @if($headcode = env('COMMENTS_HEADCODE'))
    {!! rawurldecode($headcode) !!}
    @endif
</head>
<body>
@yield('content')

@if(isset($json_data))
<script type="text/javascript">
    var app = @json($json_data);
    var app_url = "{{url('/')}}";
    var api_url = "{{url('/api')}}";
</script>
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
@endif

@yield('footer')

@if($footercode = env('COMMENTS_FOOTERCODE'))
{!! rawurldecode($footercode) !!}
@endif

</body>
</html>
