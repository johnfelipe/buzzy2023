@php($currentUser= get_current_content_user())
<div id="addComment" class="add-comment">
    @if(!$currentUser->CUSER)
    @if($currentUser->authenticated)
    <div class="logincon pull-right">
        <a href="javascript:void(0);">
            <i class="fa fa-sign-in"></i>
            <span class="name">{{$currentUser->username}}</span>
            <span class="fa fa-angle-down"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('users/' . $currentUser->username_slug)}}" class="open-popup"><i
                        class="fa fa-cog"></i>{{__('Profile')}}</a></li>
            <li><a href="{{ url('api/account')}}" class="open-popup"><i class="fa fa-cog"></i>{{__('Settings')}}</a>
            </li>
            @if($currentUser->user_type === 'admin')
            <li><a href="{{ url('admin')}}" target="_black"><i class="fa fa-dashboard"></i>{{__('Admin Panel')}}</a>
            </li>
            @endif
            <li><a href="{{url('api/logout')}}" data-reload="yes" class="do_action"><i
                        class="fa fa-sign-out"></i>{{__('Logout')}}</a></li>
        </ul>
    </div>
    @else
    <div class="logincon nolog pull-right">
        <a href="javascript:void(0);"><i class="fa fa-sign-in"></i><span class="name">{{__('Signin')}}</span> <span
                class="fa fa-angle-down"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('api/login?popup=true')}}" data-reload="yes" class="open-popup"><i
                        class="fa fa-sign-in"></i>{{__('Login')}}</a></li>
            <li><a href="{{ url('api/register?popup=true')}}" data-reload="yes" class="open-popup"><i
                        class="fa fa-user"></i>{{__('Register')}}</a></li>
            @if(env('FACEBOOK_KEY'))
            <li><a href="{{ url('api/login/facebook')}}" data-reload="yes" class="open-popup"><i
                        class="fa fa-facebook"></i>{{__('With Facebook')}}</a></li>
            @endif
            @if(env('TWITTER_KEY'))
            <li><a href="{{ url('api/login/twitter')}}" data-reload="yes" class="open-popup"><i
                        class="fa fa-twitter"></i>{{__('With Twitter')}}</a></li>
            @endif
            @if(env('GOOGLE_CLIENT_ID'))
            <li><a href="{{ url('api/login/google')}}" data-reload="yes" class="open-popup"><i
                        class="fa fa-google"></i>{{__('With Google')}}</a></li>
            @endif
        </ul>
    </div>
    @endif
    @endif
    <h3>{{$title}}</h3>

    @include('comments.pages._add_comment_form')
</div>
