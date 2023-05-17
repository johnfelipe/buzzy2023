@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2 class="pull-left">
        <i class="fa fa-users red"></i>
        <span>{{__('Themes')}}</span>
    </h2>
    <div class="pull-right">
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">

        <ul id="styleList" class="row list-unstyled styles-list">
        @foreach($themes as $theme)
            <li class="style col-md-4">
                <div class="panel @if($theme ===  $currentTheme) panel-primary @else panel-default @endif">
                    <div class="panel-heading">
                        <span id="basicName" class="style-name">
                            {{$theme}}
                        </span>
                        <span class="pull-right">
                            @if($theme ===  $currentTheme)
                            <span id="basicCurrent" class="badge">
                                {{__('Current')}}
                            </span>
                            @else
                            <a class="btn btn-primary btn-xs do_action" data-reload="yes" href={{url('admin/themes/'.$theme)}}>
                                <span class="fa fa-ok-sign fa fa-lg"></span>
                                {{__('Select This')}}
                            </a>
                            @endif
                        </span>
                    </div>
                    <div class="panel-body style-body">
                        <div class="style-preview">
                            <img src="{{asset('themes/'.$theme.'/preview.png')}}" style="width:100%"/>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
        </ul>

    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@endsection
