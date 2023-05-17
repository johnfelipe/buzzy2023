@extends('auth.app')
@section('title', __('Edit Account'))
@section('body_class', "white popup_full")
@section('head')
@endsection

@section('content')
<div class="popup-content clearfix">
@include('auth.pages._account_form', ['action' => url('api/account/update')])
</div>
@endsection
