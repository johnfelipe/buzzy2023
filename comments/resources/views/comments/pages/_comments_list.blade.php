@if(count($comments))
    @foreach($comments as $comment)
        @include('comments.pages._comment', ['comment' => $comment])
    @endforeach

   @if(!isset($hideLinks))
        {!! $comments->links() !!}
   @endif
@endif
