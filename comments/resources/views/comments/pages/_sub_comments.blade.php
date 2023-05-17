<div class="comment-replies" id="comment_content_{{$comment->id}}">
    <div class="form-loader"></div>
    @php($repliesCount = $comment->replies()->count())
    @php($maxRepliesCount = env('COMMENTS_SHOW_REPLY_COUNT', 5))
    @php($repliesSort = env('COMMENTS_REPLIES_DEFAULT_SORT', 'new'))
    <div id="comments_list{{$comment->id}}">
        @if($repliesCount > 0)
            @foreach($comment->replies()->approved()->orderCommentsBy($repliesSort)->limit($maxRepliesCount)->get() as $reply)
                @include('comments.pages._comment', ['comment' => $reply])
            @endforeach
        @endif
    </div>
    @if($repliesCount > $maxRepliesCount)
        <a class="load-more-comment load_more_replies" data-id="{{ $comment->id }}" href="javascript:void(0);">{{__('Load More Replies')}} <span class="fa fa-angle-down"></span></a>
    @endif
</div>
<div class="add-comment add-subcomment" id="open_add_subcomment_{{$comment->id}}">
    @include('comments.pages._add_comment_form', ['parent_id' => $comment->id, $defaultText= '@'. $comment->userdata->username])
</div>
