<div id="comments">
    @if(count($popularComments))
    <h3 class="title">
        <span class="popular">{{__('Popular Comments')}}</span>
    </h3>
    <div class="popular-comments" style="position: relative">
        @foreach($popularComments as $comment)
        @include('comments.pages._comment', ['comment' => $comment])
        @endforeach
    </div>
    @endif
    <h3 class="title">
        <span
            class="allcomments">{{trans_choice('{0} :count comment|[2,*] :count comments', $comments->total(), ['count' => $comments->total()])}}</span>
        <div class="short comment_sort pull-right">
            <a href="javascript:void(0);" @if(env('COMMENTS_DEFAULT_SORT')==='best' )class="active" @endif
                data-sort="best"><i class="fa fa-star"></i> {{__('Best')}}</a>
            <a href="javascript:void(0);" @if(env('COMMENTS_DEFAULT_SORT')==='old' )class="active" @endif
                data-sort="old"><i class="fa fa-sort-numeric-asc"></i> {{__('Oldest')}}</a>
            <a href="javascript:void(0);" @if(env('COMMENTS_DEFAULT_SORT', 'new' )==='new' )class="active" @endif
                data-sort="new"><i class="fa fa-sort-numeric-desc"></i> {{__('Newest')}}</a>
        </div>
    </h3>
    <div class="comments">
        <div class="form-loader"></div>
        <div id="comments_list">
            @if(count($comments))
            @include('comments.pages._comments_list', ['comments' => $comments])
            @else
            <div class="no-comment">{{__('Write the first review for this!')}}</div>
            @endif
        </div>
    </div>
</div>
@if ($hide_footer)
@include('comments.pages._comments_footer')
@endif
