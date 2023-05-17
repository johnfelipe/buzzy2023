@extends('auth.app')
@section('title', $page->title)
@section('body_class', "")
@section('head')
@endsection

@section('content')
<div class="popup-content clearfix">
    <h1>{{$page->title}}</h1>
    <p>{!!nl2br($page->body)!!}</p>
</div>
@endsection
