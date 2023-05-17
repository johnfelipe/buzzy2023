@php($currentUser= get_current_content_user())
<form action="{{url("/api/comments")}}" method="post" data-prepend="{{isset($parent_id) ? 'no' : 'yes'}}"
    onsubmit="return false;" onSubmit="return false;">
    @if(isset($parent_id))
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
    @endif
    <div class="loader-ajax"></div>
    <div class="add-comment-container">
        <img src="{{ $currentUser->icon }}" alt="{{ $currentUser->icon}}" class="usericont" />
        <div class="add-comment-form">
            <div>
                <textarea name="comment_text" class="comment_text" cols="30" rows="10"
                    placeholder="{{ $currentUser->authenticated ? isset($parent_id) ? __("Reply to this comment.") : __('Share your thoughts about this.') : __("You must have to login to post a comment.") }}">{{ isset($defaultText) ? $defaultText . ' ': '' }}</textarea>

                <div class="add-comment-form-actions">
                    <button type="submit" class="add_new_comment" @if($currentUser->authenticated)style="width:
                        160px;"@endif>
                        @if($currentUser->authenticated)
                        {!! __('Post as <b> :user </b>', ['user' => $currentUser->username]) !!}
                        @else
                        {{__('Post') }}
                        @endif
                    </button>

                    @if(!$currentUser->authenticated && !$currentUser->CUSER)
                    <div class="loginbox">
                        <div class="typerq">
                            <a href="javascript:void(0);" class="chooseiType">
                                <i class="fa fa-sign-in"></i>
                                <span class="name">{{__('Login')}}</span>
                                <span class="fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:void(0);" class="select_comment_auth selected"
                                        data-type="login">
                                        <i class="fa fa-sign-in"></i>
                                        {{__('Login')}}
                                        <i class="fa fa-selected fa-check"></i>
                                    </a>
                                </li>
                                <li><a href="javascript:void(0);" class="select_comment_auth" data-type="register"><i
                                            class="fa fa-user-plus"></i>{{__('Register')}} <i
                                            class="fa fa-selected fa-check"></i></a></li>
                                @if(env('COMMENTS_GUEST_COMMENT'))
                                <li><a href="javascript:void(0);" class="select_comment_auth" data-type="guest"><i
                                            class="fa fa-user-secret"></i>{{__('Guest')}} <i
                                            class="fa fa-selected fa-check"></i></a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="callingsing login-sign open">
                            <a href="{{ url('/api/login?popup=true')}}" data-reload="yes"
                                title="{{__('Login with Email')}}" class="social-button open-popup">
                                <span class="fa-stack easycomment fa-lg">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-comments fa-stack-1x"></i>
                                </span>
                            </a>
                            @if(env('FACEBOOK_KEY'))
                            <a href="{{ url('/api/login/facebook')}}" data-reload="yes"
                                title="{{__('Login with Facebook')}}" class="social-button open-popup">
                                <span class="fa-stack facebook fa-lg">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x"></i>
                                </span>
                            </a>
                            @endif
                            @if(env('TWITTER_KEY'))
                            <a href="{{ url('/api/login/twitter')}}" data-reload="yes"
                                title="{{__('Login with Twitter')}}" class="social-button open-popup">
                                <span class="fa-stack twitter fa-lg">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x"></i>
                                </span>
                            </a>
                            @endif
                            @if(env('GOOGLE_CLIENT_ID'))
                            <a href="{{ url('/api/login/google')}}" data-reload="yes"
                                title="{{__('Login with Google')}}" class="social-button open-popup">
                                <span class="fa-stack google fa-lg">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-google fa-stack-1x"></i>
                                </span>
                            </a>
                            @endif
                            <div class="clear"></div>
                        </div>
                        <div class="callingsing register-sign guest-sign">
                            <span class="boxinput"><input type="text" name="user_username"
                                    placeholder="{{__('Username')}}"></span>
                            <span class="boxinput"><input type="text" name="user_email"
                                    placeholder="{{__('Email')}}"></span>
                            <span class="boxinput"><input type="password" name="user_password"
                                    placeholder="{{__('Password')}}"></span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
