<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>easyComment</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{url('images/favicon.ico')}}" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 200;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .main {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }
        .content {
            text-align: center;
            display: inline-block;
            margin-top: 300px;
        }
        .name {
            font-size: 96px;
            margin-bottom: 40px;
            font-weight: 200;
        }
        @media (max-width: 560px) {
            .name {
                font-size: 66px;
            }
        }
        .name span {
            color: #008CBA;
        }
        .sub {
            font-size: 24px;
                margin-bottom: 40px;
        }
        .links a {
            color: #008CBA;
            text-decoration: none;
            font-size: 20px;
            font-weight: 300;
            margin: 0px 5px;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="content">
            <div class="name"><img src="{{url('logo@2x.png')}}"></div>
            <div class="links">
            <a href="{{url('api/login')}}">{{__('Admin Panel')}}</a> •
                <a href="http://easycomment.akbilisim.com">easyComment</a>@if(Auth::check()) • <a href="{{url('api/logout/force')}}"> Logged as {{ Auth::user()->username }}</a> @endif
                <p>{{ date('Y') }} © akbilisim</p>
            </div>
        </div>
    </div>
</body>
</html>
