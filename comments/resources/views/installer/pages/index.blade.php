@extends('installer.app')
@section('title', __('Initialization Wizard'))
@section('body_class', "white popup_full")
@section('content')
    @if(isset($requirements['errors']))
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                {{__('Please fix requirements before installation')}}
            </h3>
        </div>
        <div class="panel-body">
            <div class="bs-component">
                <ul class="list-group">
                    @foreach($requirements['requirements'] as $element => $enabled)
                    <li class="list-group-item">
                        @if($enabled)
                            <span class="badge btn-success">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        @else
                            <span class="badge btn-danger">
                                <i class="glyphicon glyphicon-remove"></i>
                            </span>
                        @endif
                        {{ $element }}
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
    @elseif(isset($permissions['errors']))
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-file"></i>
                {{__('Please fix folder permissions before installation')}}
            </h3>
        </div>
        <div class="panel-body">
            <div class="bs-component">
                <ul class="list-group">
                    @foreach($permissions['permissions'] as $permission)
                        <li class="list-group-item">
                            @if($permission['isSet'])
                                <span class="badge btn-success">
                                    <i class="glyphicon glyphicon-ok"></i>
                                </span>
                            @else
                                <span class="badge btn-danger">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </span>
                            @endif
                            {{ $permission['folder'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @else

    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-folder-close"></i>
                {{__('Database Information')}}
            </h3>
        </div>
        <div class="panel-body">

		<form action="{{ url('installer') }}" method="post" class="post_form">
			<div class="panel-group">
				<div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Database Host')}}</label></div>
                        <div class="col-md-10"><input type="text" name="host" class="form-control" value="localhost" placeholder="{{__('Database Host')}}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Database Port')}}</label></div>
                        <div class="col-md-10"><input type="text" name="port" class="form-control" value="3306" placeholder="{{__('Database Port')}}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Database Name')}}</label></div>
                        <div class="col-md-10"><input type="text" name="database" class="form-control" placeholder="{{__('Database Name')}}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Database Username')}}</label></div>
                        <div class="col-md-10"><input type="text" name="username" class="form-control" placeholder="{{__('Database Username')}}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Database Password')}}</label></div>
                        <div class="col-md-10"><input type="text" name="password" class="form-control" placeholder="{{__('Database Password')}}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Database Prefix')}}</label></div>
                        <div class="col-md-10"><input type="text" name="prefix" value="easy_" class="form-control" placeholder="{{__('Database Prefix')}}"></div>
                    </div>
                    <hr/>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Admin Email')}}</label></div>
                        <div class="col-md-10"><input type="text" name="admin_email" class="form-control" placeholder="{{__('Admin Email')}}"></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2"><label>{{__('Admin Password')}}</label></div>
                        <div class="col-md-10"><input type="text" name="admin_password" class="form-control" placeholder="{{__('Admin Password')}}"></div>
                    </div>
				</div>
            </div>
			<button class="btn btn-success pull-right" type="submit">
				{{__('Install')}}
			</button>
			</form>
        </div>
    </div>

    @endif
@stop
