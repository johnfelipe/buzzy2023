@extends('installer.app')
@section('title', __('Update'))
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-home"></i>
                {{ __('Update') }}
            </h3>
        </div>
        <div class="panel-body">
            <a class="btn btn-success do_action" data-reload="yes"href="{{ url('installer/update') }}">
                {{ __('Update') }}
            </a>
        </div>
    </div>
@stop
