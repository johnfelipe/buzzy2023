<div class="commentsfooter">
    <div class="footer-links">
    <div class="text-smaller text-gray">
        {{env('APP_NAME')}} © {{ date('Y') }}
        <br>
        @foreach(App\Page::get() as $key=> $page)
            @if($key!==0)
            <span class="bullet"></span>
            @endif
        <a  href="{{url('/pages/'.$page->id)}}" class="open-popup">{{$page->title}}</a>
        @endforeach
    </div>
    </div>
    <div class="footer-logo">
        <a href="javascript:void(0);" onclick="showPages('about')">
            <img alt="{{env('APP_NAME')}}" src="{{ url('logo.png') }}">
        </a>
    </div>
</div>
