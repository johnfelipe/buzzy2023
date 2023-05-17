<nav class="navbar navbar-inverse navbar-fixed-top navbar-styled">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">{{__('Toggle')}}</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand flex" href="{{url('/admin')}}">
            <img alt={{env('APP_NAME')}} style="max-height:20px" src="{{env('APP_LOGO', url('logo.png'))}}">
            <span style="color:rgba(255,255,255,0.3);">|</span>
            {{__('Admin Panel')}}
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div id="navbar" class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
        <li @if(request()->is('admin'))class="active"@endif>
            <a href="{{ url('admin')}}">
                <i class="fa fa-dashboard"></i> {{__('Dashboard')}}
            </a>
        </li>
        <li @if(request()->is('admin/comments')) class="dropdown active" @else class="dropdown" @endif>
            <a href="{{url('admin/comments')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-comment"></i> <span>{{__('Comments')}}</span> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{url('admin/comments')}}">{{__('All Comments')}}</a></li>
                <li><a href="{{url('admin/comments?approve=unapproved')}}">{{__('Pending Comments')}}</a></li>
            </ul>
        </li>
        <li @if(request()->is('admin/reports'))class="active"@endif>
            <a href={{url('admin/reports')}}>
                <i class="fa fa-list-alt"></i> <span>{{__('Reports')}}</span>
            </a>
        </li>
        <li @if(request()->is('admin/users'))class="active"@endif>
            <a href={{url('admin/users')}}>
                <i class="fa fa-user"></i> <span>{{__('Users')}}</span>
            </a>
        </li>
        <li @if(request()->is('admin/pages'))class="active"@endif>
            <a href={{url('admin/pages')}}>
                <i class="fa fa-file-text"></i> <span>{{__('Pages')}}</span>
            </a>
        </li>
        <li @if(request()->is('admin/settings')) class="dropdown active" @else class="dropdown" @endif>
            <a href="{{url('admin/settings')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cog"></i> <span>{{__('Settings')}}</span> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{url('admin/settings')}}">{{__('General Settings')}}</a></li>
                <li><a href="{{url('admin/themes')}}">{{__('Themes')}}</a></li>
                <li><a href="{{url('admin/translations')}}">{{__('Translations')}}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i> {{Auth::user()->username}} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{url('admin/users/'.Auth::user()->id)}}">{{__('Profile')}}</a></li>
                <li><a href="{{url('api/logout')}}" data-redirect="{{url('api/login')}}" class="do_action">{{__('Logout')}}</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>
