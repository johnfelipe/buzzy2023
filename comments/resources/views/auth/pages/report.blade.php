@extends('auth.app')
@section('title', __('Report Comment'))
@section('head')
@endsection

@section('content')

<div class="popup-content clearfix">
    @if(Auth::user()->reports()->where('comment_id', $comment->id)->first())
    <div class="alert alert-danger">{{__('You have already reported this comment.')}}</div>
    @else
    <div class="alert alert-info">{{__('You are about to report comment #:count', ['count' => $comment->id])}}</div>
    <form action="{{url('api/comments/'.$comment->id.'/report')}}" method="post" class="post_form" autocomplete="off" data-popup="{{request()->query('popup') ? 'yes' : 'no'}}">
        <div class="form-group">
            <label for="inputPassword" class="control-label">{{__('Reason')}} {{__('(Optional)')}}</label>
            <textarea type="text" class="form-control" id="body" name="body" style="height:200px" placeholder="{{__('Explain why you report this comment.')}}"></textarea>
        </div>
        <button type="submit" class="btn btn-block btn-success btn-large">{{__('Report')}}</button>
    </form>
    @endif
</div>

@endsection
