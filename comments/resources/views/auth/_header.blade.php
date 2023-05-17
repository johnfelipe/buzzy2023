<nav class="navbar navbar-inverse navbar-fixed-top navbar-styled">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-xs-8">
                <a class="navbar-brand brand" href="javascript:;">
                    <img alt="{{env('APP_NAME')}}" style="max-height:20px" src="{{env('APP_LOGO', url('logo.png'))}}">
                    <span style="color:rgba(255,255,255,0.3);padding-left:10px;padding-right:10px">|</span> @yield('title')
                </a>
            </div>
            <div class="col-sm-2 col-xs-4" style="margin-top:6px">
                @include('auth._language_select')
            </div>
        </div>
    </div>
</nav>
