<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>@yield('title', env('APP_NAME'))</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
<link rel="icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet"/>
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/bootstrap-theme.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet"/>
<link href="{{asset('css/admin.css')}}" rel="stylesheet" />
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

@yield('head')
<style>
body {
    font-family: "Open Sans";
    padding: 0 !important;
}
body.white {
    background-color: #fff;
}
.navbar {
    margin: 0
}
@media (max-width: 800px){
    .container {
        width: 100%;
    }
}
.popup-container {
    width: 380px;
    display: block;
    margin: 100px auto 0 auto;
}
.popup_large .popup-container {
    width: 580px;
}
.popup_full .popup-container {
    width: 100%;
    margin: 60px 0 0 0;
    padding: 15px;
}
.popup-content {
    padding: 16px 28px 23px;
    background: #f9f9f9;
    border: 1px solid #d5d5d5;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    box-shadow: 0px 0px 2px #dadada, inset 0px -3px 0px #e6e6e6;
}
.popup-footer-desc {
    margin-top: 15px;
    text-align: center;
}
</style>

</head>
<body id="js-content" class="@yield('body_class')">

@include('auth._header')

<div class="popup-container">

    @yield('content')

</div> <!-- /account-container -->

<!-- /footer -->
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
    var app_url = "{{url('/')}}";
    var api_url = "{{url('/api')}}";
</script>
<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
<!-- /footer js -->
<script>
(function () {
    // https://gist.github.com/3108177
    var supportsGCS = "defaultView" in window.document && "getComputedStyle" in window.document.defaultView;

    function getStyle(element, property) {
        // `element.ownerDocument` returns the used style values relative to the
        // element's parent document (which may be another frame). `defaultView`
        // is required for Safari 2 support and when retrieving framed styles in
        // Firefox 3.6 (https://github.com/jquery/jquery/pull/524#issuecomment-2241183).
        var style = supportsGCS ? element.ownerDocument.defaultView.getComputedStyle(element, null) : element.currentStyle;
        return (style || element.style)[property];
    }

    function getWindowPadding() {
        // Based in part on
        // http://stackoverflow.com/questions/1275849/get-height-of-enter-browser-window-in-ie8

        if (window.outerHeight !== undefined) {
            return {
                x: window.outerWidth - window.innerWidth,
                y: window.outerHeight - window.innerHeight
            }
        }

        var docElem = document.documentElement;

        // Old browser (IE8 and below). Need to resize window, observe change in
        // clientWidth/Height in order to determine padding.
        var oldX = docElem.clientWidth;
        var oldY = docElem.clientHeight;

        // clientWidth/Height *will* be smaller than the current window size. But
        // not by much. I figure this is the least jarring size to pick.
        window.resizeTo(oldX, oldY);

        var padding = {
            x: oldX - docElem.clientWidth,
            y: oldY - docElem.clientHeight
        };

        // Restore window to original dimensions
        window.resizeTo(oldX + padding.x, oldY + padding.y);

        return padding;
    }

    function getScrollbarWidth() {
        // credits: http://davidwalsh.name/detect-scrollbar-width
        // Create the measurement node
        var scrollDiv = document.createElement("div");
        scrollDiv.className = "scrollbar-measure";
        document.body.appendChild(scrollDiv);

        // Get the scrollbar width
        var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;

        // Delete the DIV
        document.body.removeChild(scrollDiv);
        return scrollbarWidth;
    }

    if (window.resizeTo) {
        window.onload = function () {
            // Should only calculate document dimensions after page has fully loaded.
            // I've also observed some funky results without using setTimeout to wrap
            // the callback. Other applications seem to resize on a delay, so I suspect
            // this is necessary.
            setTimeout(function () {
                var content = document.getElementById('js-content'),
                    buffer = 130,
                    width = content.offsetWidth+60,
                    height = content.offsetHeight,
                    padding = getWindowPadding(),
                    scrollWidth = getScrollbarWidth(),
                    viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
                    viewportWidth = window.innerWidth || ((document.documentElement.clientWidth || document.body.clientWidth) + scrollWidth),
                    browser = window.outerHeight || viewportHeight;

                // resize only when content is cropped
                if(viewportHeight < height + buffer || viewportWidth < width) {
                    window.resizeTo(Math.max(width, viewportWidth), height + (browser - viewportHeight) + buffer);
                }
            }, 250);
        }
    }
}());
</script>
@yield('footer')

</body>
</html>
