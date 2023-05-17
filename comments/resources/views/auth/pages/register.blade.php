@extends('auth.app')
@section('title', __('Register'))
@section('head')
@endsection

@section('content')

<div class="popup-content clearfix">
    <form action="{{url('api/register')}}" method="post" class="post_form" autocomplete="off" data-popup="{{request()->query('popup') ? 'yes' : 'no'}}">
        <div class="form-group">
            <label class="control-label">{{__('Username')}}</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="{{__('Username')}}">
        </div>
        <div class="form-group">
            <label class="control-label">{{__('Email')}}</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="{{__('Email')}}">
        </div>
        <div class="form-group">
            <label for="inputPassword" class="control-label">{{__('Password')}}</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="{{__('Password')}}">
        </div>
        <div class="checkbox">
            <label>
                <input id="agree_terms" name="agree_terms" type="checkbox"> {{__('Agree with the Terms & Conditions.')}}
            </label>
        </div>
        @include('auth.pages._recaptcha_script')
        <button type="submit" class=" btn btn-success btn-large pull-right">{{__('Register')}}</button>
    </form>
</div>

<div class="popup-footer-desc">
    {{__('Already have an account?')}} <a href="{{url('api/login')}}">{{__('Login to your account')}}</a>
</div>

@endsection
