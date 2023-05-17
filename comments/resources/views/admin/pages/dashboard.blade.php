@extends('admin.app')

@section('head')
@endsection

@section('content')
<div class="row">

    <div class="col-md-6">

        @include('admin.widgets.todays_stats')
        @include('admin.widgets.shortcuts')
        @include('admin.widgets.the_code')

    </div> <!-- /col-6-->

    <div class="col-md-6">
        @include('admin.widgets.pending_comments')
        @include('admin.widgets.latest_comments')
    </div> <!-- /col-6-->
</div>
<!-- /row -->
@endsection
