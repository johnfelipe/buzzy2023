<div class="footer clearfix">
<div class="footer-inner">
    <div class="container">
    <div class="row" style="display:flex;align-items:center">
        <div class="col-md-10"> &copy; {{date('Y') }} <a href="{{url('/')}}">{{env('APP_NAME')}}</a>. </div>
        <div class="col-md-2">
            @include('auth._language_select')
        </div>
        <!-- /span12 -->
    </div>
    <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /footer-inner -->
</div>
