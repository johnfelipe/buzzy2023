@extends('admin.app')

@section('head')
@endsection

@section('content')
<div class="page-header">
    <h2>
        <i class="fa fa-users red"></i>
        <span>{{$user->username}}</span>
    </h2>
    <div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-4">
        <div class="widget">
            <div class="widget-header">
                <i class="fa fa-user"></i>
                <span>{{__('User Profile')}}</span>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <img src="{{image_url_create($user->icon, 'm', 'avatars')}}" width="90" style="float:left">
                <div style="margin-left:100px;">
                    <p class="lead" style="margin-bottom: 5px">{{$user->username}}

                        <a class="badge badge-success" href="{{url('/admin/users/'.$user->id.'?page=edit')}}">{{__("Edit Profile")}}</a>
                    </p>
                    <div style="margin-bottom: 5px">
                        <a href="{{url('/admin/users/'.$user->id)}}" style="color:#444;">
                            {{__(':count Comments', ['count' => $user->comments()->parent()->count()])}}
                        </a>
                        - {{__(':count Replies', ['count' => $user->comments()->onlyReplies()->count()])}}
                        @if($user->isOnline())
                        - <span class="text-success">{{__('Online')}}</span>
                        @else
                        - <span class="text-secondary">{{__('Offline')}}</span>
                        @endif
                    </div>
                    <div>
                        @if($user->user_type=="banned")
                        <a href="{{url('/admin/users/'.$user->id.'/action?do=unlock')}}" title="{{__("Unlock")}}" class="btn btn-danger do_action" data-reload="yes">
                            <i class="fa fa-unlock" style="margin-right:0"></i>
                        </a>
                        @else
                            @if($user->user_type=="admin")
                                <a href="{{url('/admin/users/'.$user->id.'/action?do=member')}}" title="{{__("Make User")}}" class="btn btn-danger do_action" data-reload="yes">
                                    <i class="fa fa-download" style="margin-right:0"></i>
                                </a>
                            @else
                                <a href="{{url('/admin/users/'.$user->id.'/action?do=admin')}}" title="{{__("Make Admin")}}" class="btn btn-warning do_action" data-reload="yes" >
                                    <i class="fa fa-upload" style="margin-right:0"></i>
                                </a>
                                <a href="{{url('/admin/users/'.$user->id.'/action?do=ban')}}" title="{{__("Ban")}}" class="btn btn-default do_action"  data-reload="yes">
                                    <i class="fa fa-lock" style="margin-right:0"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

            </div> <!-- /widget-content -->
        </div> <!-- /widget -->
        @include('admin.widgets.user_detail')
    </div>
    <div class="col-md-8">
        @if(request()->get('page') === 'edit')
            <div class="widget">
                <div class="widget-header">
                    <i class="fa fa-thumbs-up"></i>
                    <span>{{__('Edit Profile')}}</span>
                </div> <!-- /widget-header -->
                <div class="widget-content">

                    @include('auth.pages._account_form', ['action' => url('/admin/users/'.$user->id), 'full_access' => true])

                </div> <!-- /widget-content -->
            </div> <!-- /widget -->
        @else
            <div class="widget">
                <div class="widget-header">
                    <i class="fa fa-thumbs-up"></i>
                    <span>{{__('Comments')}}</span>
                </div> <!-- /widget-header -->
                <div class="widget-content">

                    <!-- easyComment Content Div -->
                    <div id="easyComment_Content"></div>

                    <script type="text/javascript">
                    var easyComment_ByUserID = '{{$user->id}}';
                    var easyComment_Theme = 'Default';
                    var easyComment_Domain = '{{url("/")}}';
                    (function() {
                        var EC = document.createElement('script');
                        EC.type = 'text/javascript';
                        EC.async = true;
                        EC.src =  easyComment_Domain +  '/plugin/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(EC);
                    })();
                    </script>

                </div> <!-- /widget-content -->
            </div> <!-- /widget -->
        @endif
    </div>
</div> <!-- /row -->

@endsection
@section('footer')
@endsection
