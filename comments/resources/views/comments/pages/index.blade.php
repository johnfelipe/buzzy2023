@extends('comments.app')

@section('content')

<!-- add comment -->
@include('comments.pages._add_comment')

<!-- comments -->
@include('comments.pages._comments')

@endsection
@section('footer')
@if(!get_current_content_user()->authenticated)
@include('auth.pages._recaptcha_script')
@endif
@endsection
