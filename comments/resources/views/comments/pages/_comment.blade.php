@php($currentUser=get_current_content_user())
<div class="comment" id="comment{{ $comment->id }}">
    <img class="avatar" src="{{ $comment->userdata->icon }}" alt="{{ $comment->userdata->username }}" />
    <div class="comment-content">
        <div class="comment-top">
            <span class="report">
                @if($currentUser->user_type === 'admin')
                <a href="{{url('admin/comments/'.$comment->id)}}" target="_blank">
                    <span class="fa fa-pencil"></span>
                </a>
                @elseif($currentUser->authenticated)
                <a href="{{url('api/comments/'.$comment->id) .'/report?popup=yes'}}" class="open-popup"
                    title="{{__('Report')}}">
                    <span class="fa fa-flag"></span>
                </a>
                @endif
            </span>
            @if($comment->userdata->link && $comment->userdata->type === 'auth')
            <a href="{{ $comment->userdata->link}}" target="_blank" data-id="{{ $comment->userdata->id }}"
                data-width="600" data-height="600"
                class="content_user_info open-popup user-{{$comment->userdata->user_type}}">
                @elseif($comment->userdata->link && $comment->userdata->type === 'cuser')
                <a href="{{ $comment->userdata->link}}" class="user-cuser" target="_blank">
                    @else
                    <a href="javascript:void(0);" class="user-guest" style="cursor: default;">
                        @endif
                        {{ $comment->userdata->username }}
                    </a>
                    @if($comment->userdata->user_type)
                    <span class="tag {{$comment->userdata->user_type}}">
                        {{ $comment->userdata->user_type ==='admin' ? __('Admin') : ($comment->userdata->user_type ==='mod' ? __('Moderator') : ($comment->userdata->user_type ==='guest' ? __('Guest') : ''))}}
                    </span>
                    @endif
                    <span class="date"><span>•</span> {{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <div class="comment-spoiler-text" @if(!$comment->spoiler)style="display: none"@endif>
            {{ __('This review contains spoilers.')}}
            <span>{{ __('Click here if you want to read.')}}</span>
        </div>
        <div class="comment-text-p" @if($comment->spoiler)style="display: none"@endif>
            <p>
                {!! parse_comment_text($comment->comment) !!}
            </p>
        </div>
        <div class="comment-actions">
            <a href="javascript:void(0);" class="comment_open_reply_form"
                data-id="{{ $comment->id }}">{{ __('Reply') }}</a>
            <span class="dot">•</span>
            <a href="javascript:void(0);" class="like comment_vote" data-id="{{ $comment->id }}" data-type="1">
                <abbr id="like_{{ $comment->id }}">{{ $comment->votes()->likes()->count() }}</abbr>
                <span class="fa fa-thumbs-up"></span>
            </a>
            <span class="dot">|</span>
            <a href="javascript:void(0);" class="dislike comment_vote" data-id="{{ $comment->id }}" data-type="0">
                <abbr id="dislike_{{ $comment->id }}">{{ $comment->votes()->dislikes()->count() }}</abbr>
                <span class="fa fa-thumbs-down"></span>
            </a>
        </div>

        @include('comments.pages._sub_comments', ['comment' => $comment])
    </div>
</div>
