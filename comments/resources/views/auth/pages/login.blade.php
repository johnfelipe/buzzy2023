@extends('auth.app')
@section('title', __('Login'))
@section('head')
@endsection

@section('content')

<div class="popup-content clearfix">
    <form action="{{url('api/login')}}" method="post" class="post_form" autocomplete="off" data-popup="{{request()->query('popup') ? 'yes' : 'no'}}">
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
                <input id="rememberme" name="rememberme" type="checkbox"> {{__('Keep me signed in')}}
            </label>
        </div>
        @include('auth.pages._recaptcha_script')

        <button type="submit" class="btn btn-block btn-success btn-large">{{__('Login')}}</button>
    </form>
</div>

<div class="popup-footer-desc">
    {{__("Don't have an account?")}} <a href="{{url('api/register')}}">{{__('Register')}}</a>
</div>

@endsection
