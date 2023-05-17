@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2 class="pull-left">
        <i class="fa fa-users red"></i>
        <span>{{__('Settings')}}</span>
    </h2>
    <div class="pull-right">
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">

        <div class="widget ">
            <div class="widget-content">

                <div class="tabbable">
                    <ul class="nav nav-tabs" style="  background-color: #eee; margin: -21px -19px 0 -16px;">
                        <li class="active">
                            <a href="#core" data-toggle="tab">{{__('Main Settings')}}</a>
                        </li>
                        <li><a href="#allowedsites" data-toggle="tab">{{__('Allowed Domains')}}</a></li>
                        <li><a href="#social" data-toggle="tab">{{__('Social Logins')}}</a></li>
                        <li><a href="#recaptcha" data-toggle="tab">{{__('Recaptcha')}}</a></li>
                        <li><a href="#options" data-toggle="tab">{{__('Commenting')}}</a></li>
                        <li><a href="#advanced" data-toggle="tab">{{__('Advanced')}}</a></li>
                    </ul>
                    <br>

                    <form action="{{url('/admin/settings')}}" method="post" class="post_form" data-reload="yes"
                        enctype="multipart/form-data">
                        <fieldset>
                            <div class="tab-content">
                                <div class="tab-pane active" id="core">
                                    <div class="form-group">
                                        <label class="control-label" for="APP_LOCALE">{{__("Site Language")}}</label>
                                        <div class="controls">
                                            @php($languages = get_available_languages())
                                            <select name="APP_LOCALE" id="APP_LOCALE" class="form-control">
                                                @foreach($languages as $language)
                                                <option value="{{$language}}" @if(env('APP_LOCALE', 'en' )===$language)
                                                    selected @endif>{{$language}}
                                                    ({{get_translatable_language($language)}})</option>
                                                @endforeach
                                            </select>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="APP_NAME">{{__("Site Name")}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="APP_NAME" name="APP_NAME"
                                                value="{{env('APP_NAME')}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="APP_URL">{{__("Site Url")}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="APP_URL" name="APP_URL"
                                                value="{{env('APP_URL', url('/'))}}">
                                            <p class="help-block"><code>http://example.com/</code> or
                                                <code>http://comments.example.com/</code> or
                                                <code>http://www.example.com/comments/</code> vs</p>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label">{{__('Site Logo')}}</label>
                                        <div class="controls">
                                            <p class="help-block"><img src="{{env('APP_LOGO', url('logo.png'))}}"></p>
                                            <input type="file" class="form-control" name="APP_LOGO" value="">

                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label"
                                            for="APP_EMAIL">{{__('Contact Email Address')}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="APP_EMAIL" name="APP_EMAIL"
                                                value="{{env('APP_EMAIL')}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                </div>
                                <div class="tab-pane" id="allowedsites">
                                    <div class="form-group">
                                        <label class="control-label"
                                            for="ALLOWED_DOMAINS">{{__('Allowed Domain Names')}}</label>
                                        <div class="controls">
                                            <?php
                                        $domains="";
                                        foreach(explode(",", env('ALLOWED_DOMAINS')) as $line){
                                            if(!empty($line)){
                                                $domains=$domains."$line\r";
                                            }
                                        }
                                    ?>
                                            <textarea type="text" class="form-control" style="height:200px"
                                                id="ALLOWED_DOMAINS" name="ALLOWED_DOMAINS">{{$domains}}</textarea>
                                            <p>
                                                {{__('This is important to use! You must allow only your domain names. So commenting can only be allowed from this domains.')}}
                                                <br>{{__('You have to enter your domain names to per line as:')}}
                                                <code>yourdomainname.com</code> /
                                                <code>yoursubdomain.yourdomainname.com</code>
                                            </p>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                </div>
                                <div class="tab-pane" id="social">
                                    <div class="form-group">
                                        <label class="control-label" for="FACEBOOK_KEY">FACEBOOK KEY</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="FACEBOOK_KEY"
                                                name="FACEBOOK_KEY" value="{{env('FACEBOOK_KEY')}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="FACEBOOK_SECRET">FACEBOOK SECRET</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="FACEBOOK_SECRET"
                                                name="FACEBOOK_SECRET"
                                                value="{{ env('APP_DEMO') && \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('FACEBOOK_SECRET') }}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="FACEBOOK_SECRET">FACEBOOK REDIRECT URI</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="FACEBOOK_REDIRECT_URI"
                                                name="FACEBOOK_REDIRECT_URI"
                                                value="{{url('api/login/facebook/callback')}}" disabled>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <hr />
                                    <div class="form-group">
                                        <label class="control-label" for="GOOGLE_CLIENT_ID">GOOGLE CLIENT ID</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="GOOGLE_CLIENT_ID"
                                                name="GOOGLE_CLIENT_ID" value="{{env('GOOGLE_CLIENT_ID')}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="GOOGLE_CLIENT_SECRET">GOOGLE API
                                            SECRET</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="GOOGLE_CLIENT_SECRET"
                                                name="GOOGLE_CLIENT_SECRET"
                                                value="{{ env('APP_DEMO') && \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('GOOGLE_CLIENT_SECRET') }}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="GOOGLE_CLIENT_SECRET">GOOGLE REDIRECT URI
                                        </label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="GOOGLE_CALLBACK_URL"
                                                name="GOOGLE_REDIRECT_URI" value="{{url('api/login/google/callback')}}"
                                                disabled>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <hr />
                                    <div class="form-group">
                                        <label class="control-label" for="TWITTER_KEY">TWITTER KEY</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="TWITTER_KEY" name="TWITTER_KEY"
                                                value="{{env('TWITTER_KEY')}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="TWITTER_SECRET">TWITTER SECRET</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="TWITTER_SECRET"
                                                name="TWITTER_SECRET"
                                                value="{{ env('APP_DEMO') && \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('TWITTER_SECRET') }}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="TWITTER_SECRET">TWITTER REDIRECT URI</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="TWITTER_REDIRECT_URI"
                                                name="TWITTER_REDIRECT_URI"
                                                value="{{url('api/login/twitter/callback')}}" disabled>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                </div>

                                <div class="tab-pane" id="recaptcha">
                                    <div class="form-group">
                                        <label class="control-label" for="GOOGLE_RECAPTCHA_KEY">GOOGLE RECAPTCHA V3
                                            KEY</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="GOOGLE_RECAPTCHA_KEY"
                                                name="GOOGLE_RECAPTCHA_KEY" value="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                            <p><a href="https://www.google.com/recaptcha/intro/v3.html"
                                                    target="_blank">{{__('Get your key from here.')}}</a></p>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="GOOGLE_RECAPTCHA_SECRET">GOOGLE RECAPTCHA V3
                                            SECRET</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="GOOGLE_RECAPTCHA_SECRET"
                                                name="GOOGLE_RECAPTCHA_SECRET"
                                                value="{{ env('APP_DEMO') && \Auth::user()->email == 'demo@admin.com' ?  "-YOU DON'T HAVE PERMISSION TO SEE THAT-" : env('GOOGLE_RECAPTCHA_SECRET') }}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                </div>
                                <div class="tab-pane" id="advanced">
                                    <div class="form-group">
                                        <label class="control-label" for="COMMENTS_HEADCODE">{{__('Head Code')}}</label>
                                        <div class="controls">
                                            <textarea type="text" class="form-control" style="height:200px"
                                                id="COMMENTS_HEADCODE"
                                                name="COMMENTS_HEADCODE">{!! rawurldecode(env('COMMENTS_HEADCODE')) !!}</textarea>
                                            <p>{{__('You can add your meta tags. Custom style codes etc.')}}</p>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_FOOTERCODE">{{__('Footer Code')}}</label>
                                        <div class="controls">
                                            <textarea type="text" class="form-control" style="height:200px"
                                                id="COMMENTS_FOOTERCODE"
                                                name="COMMENTS_FOOTERCODE">{!! rawurldecode(env('COMMENTS_FOOTERCODE')) !!}</textarea>
                                            <p>{{__('You can add your google analytics code or custom js codes in here.')}}
                                            </p>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                </div>
                                <div class="tab-pane" id="options">
                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_USE_APPROVAL">{{__('Using Comments approval system')}}</label>
                                        <div class="controls">
                                            <select name="COMMENTS_USE_APPROVAL" id="COMMENTS_USE_APPROVAL"
                                                class="form-control" style="width: 150px;">
                                                <option value="true" @if(env('COMMENTS_USE_APPROVAL', true))selected
                                                    @endif>{{__('Yes')}}</option>
                                                <option value="false" @if(!env('COMMENTS_USE_APPROVAL', true))selected
                                                    @endif>{{__('No')}}</option>
                                            </select>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_TITLE">{{__('Default comments title')}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="COMMENTS_TITLE"
                                                name="COMMENTS_TITLE" value="{{env('COMMENTS_TITLE', __('Comments'))}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_POPULAR_COUNT">{{__('Limit the number of popular comments')}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control " id="COMMENTS_POPULAR_COUNT"
                                                name="COMMENTS_POPULAR_COUNT"
                                                value="{{env('COMMENTS_POPULAR_COUNT', 3)}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_POPULAR_LIKE_COUNT">{{__('Like vote count for popular comments')}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control " id="COMMENTS_POPULAR_LIKE_COUNT"
                                                name="COMMENTS_POPULAR_LIKE_COUNT"
                                                value="{{env('COMMENTS_POPULAR_LIKE_COUNT', 10)}}">
                                            <p>{{__('If an comment gets # number of likes then well show that comment in popular comments')}}
                                            </p>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_PAGE_COUNT">{{__('Limit the number of comments per page')}}</label>
                                        <div class="controls">
                                            <input type="text" class="form-control " id="COMMENTS_PAGE_COUNT"
                                                name="COMMENTS_PAGE_COUNT" value="{{env('COMMENTS_PAGE_COUNT', 15)}}">
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_SHOW_FOOTER">{{__('Show Footer Links (About Page Link, Terms Page Link, Logo etc)')}}</label>
                                        <div class="controls">
                                            <select name="COMMENTS_SHOW_FOOTER" id="COMMENTS_SHOW_FOOTER"
                                                class="form-control" style="width: 150px;">
                                                <option value="true" @if(env('COMMENTS_SHOW_FOOTER', true))selected
                                                    @endif>{{__('Yes')}}</option>
                                                <option value="false" @if(!env('COMMENTS_SHOW_FOOTER', true))selected
                                                    @endif>{{__('No')}}</option>
                                            </select>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_GUEST_COMMENT">{{__('Guest Comments')}}</label>
                                        <div class="controls">
                                            <select name="COMMENTS_GUEST_COMMENT" id="COMMENTS_GUEST_COMMENT"
                                                class="form-control" style="width: 150px;">
                                                <option value="true" @if(env('COMMENTS_GUEST_COMMENT', true))selected
                                                    @endif>{{__('Yes')}}</option>
                                                <option value="false" @if(!env('COMMENTS_GUEST_COMMENT', true))selected
                                                    @endif>{{__('No')}}</option>
                                            </select>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_DEFAULT_SORT">{{__('Comments Default Sort')}}</label>
                                        <div class="controls">
                                            <select name="COMMENTS_DEFAULT_SORT" id="COMMENTS_DEFAULT_SORT"
                                                class="form-control" style="width: 150px;">
                                                <option value="new" @if(env('COMMENTS_DEFAULT_SORT', 'new' )==='new'
                                                    )selected @endif>{{__('Newest')}}</option>
                                                <option value="old" @if(env('COMMENTS_DEFAULT_SORT', 'new' )==='old'
                                                    )selected @endif>{{__('Oldest')}}</option>
                                                <option value="best" @if(env('COMMENTS_DEFAULT_SORT', 'new' )==='best'
                                                    )selected @endif>{{__('Best')}}</option>
                                            </select>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                    <div class="form-group">
                                        <label class="control-label"
                                            for="COMMENTS_REPLIES_DEFAULT_SORT">{{__('Replies Default Sort')}}</label>
                                        <div class="controls">
                                            <select name="COMMENTS_REPLIES_DEFAULT_SORT"
                                                id="COMMENTS_REPLIES_DEFAULT_SORT" class="form-control"
                                                style="width: 150px;">
                                                <option value="new" @if(env('COMMENTS_REPLIES_DEFAULT_SORT', 'new'
                                                    )==='new' )selected @endif>{{__('Newest')}}</option>
                                                <option value="old" @if(env('COMMENTS_REPLIES_DEFAULT_SORT', 'new'
                                                    )==='old' )selected @endif>{{__('Oldest')}}</option>
                                                <option value="best" @if(env('COMMENTS_REPLIES_DEFAULT_SORT', 'new'
                                                    )==='best' )selected @endif>{{__('Best')}}</option>
                                            </select>
                                        </div> <!-- /controls -->
                                    </div> <!-- /form-group -->

                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                                <a class="btn" href="{{url('admin/')}}" style="float:right">{{__('Cancel')}}</a>
                            </div> <!-- /form-actions -->
                        </fieldset>
                    </form>

                </div>

            </div>
        </div>

    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@endsection
