@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2>
        <i class="fa fa-comments red"></i>
        <span>{{__('Comment ID: # :count', ['count' => $comment->id])}}</span>
    </h2>
    <div></div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="row">
        <div class="col-md-8">
            <div class="widget">
                <div class="widget-header">
                    <i class="fa fa-comment"></i>
                    <span>{{__('Edit Comment: # :count', ['count' => $comment->id])}}</span>
                </div> <!-- /widget-header -->
                <div class="widget-content">
                    <form action="{{url('admin/comments/'.$comment->id)}}" method="post" class="post_form">
                        <div class="form-group clear">
                            <a href="{{url('admin/users/'.$comment->userdata->id)}}">
                                <img src="{{$comment->userdata->icon}}" style="width:35px;float:left;margin-right:8px;">
                                <b style="float:left;font-weight:bold;">{{$comment->userdata->username}}</b>
                                <span class="tag {{$comment->userdata->user_type}}">
                                    {{ $comment->userdata->user_type ==='admin' ? __('Admin') : ($comment->userdata->user_type ==='mod' ? __('Moderator') : __('Member'))}}
                                </span>
                                <br>
                                <span style="font-size:11px">{{$comment->created_at->diffForHumans()}}</span>
                            </a>
                            <div class="clear"> </div>
                        </div>
                        <div class="form-group clear">
                            <label class="lab">{{__('Comment')}}</label>
                            <textarea name="comment" class="inputug"
                                style="width:100%;height:217px;">{{$comment->comment}}</textarea>
                            <div class="clear"> </div>
                        </div>
                        <div class="postgo_section">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>
                                {{__('Edit')}}</button>
                            <a class="btn" href="comments.php" type="submit">{{__('Cancel')}}</a>
                            <a class="btn btn-danger do_action" data-redirect={{url('admin/comments')}}
                                style="float:right" onclick='return confirm({{__("Do you realy want this?")}});'
                                title='{{__('Delete Comment & Report')}}'
                                href={{url('admin/comments/'.$comment->id.'/destroy')}}>
                                <i class='fa fa-remove-sign'></i> {{__('Delete')}}
                            </a>
                        </div>
                    </form>
                </div> <!-- /widget-content -->
            </div> <!-- /widget -->
        </div>
        <div class="col-md-4">
            <div class="widget">
                <div class="widget-header">
                    <i class="fa fa-thumbs-up"></i>
                    <span>{{__('Who Likes :count', ['count' => $comment->id])}}</span>
                </div> <!-- /widget-header -->
                <div class="widget-content">
                    @php($likes = $comment->votes()->likes()->limit(5)->get())
                    @if(count($likes))
                    @foreach($likes as $like)
                    @include('admin.pages._user_list_item', ['user' => $like->user, 'desc' =>
                    $like->created_at->diffForHumans()])
                    @endforeach
                    @else
                    {{__('Nothing to see here')}}
                    @endif
                </div> <!-- /widget-content -->
            </div> <!-- /widget -->
            <div class="widget">
                <div class="widget-header">
                    <i class="fa fa-thumbs-down"></i>
                    <span>{{__('Who Unlikes :count', ['count' => $comment->id])}}</span>
                </div> <!-- /widget-header -->
                <div class="widget-content">
                    @php($dislikes = $comment->votes()->dislikes()->limit(5)->get())
                    @if(count($dislikes))
                    @foreach($dislikes as $dislike)
                    @include('admin.pages._user_list_item', ['user' => $dislike->user, 'desc' =>
                    $dislike->created_at->diffForHumans()])
                    @endforeach
                    @else
                    {{__('Nothing to see here')}}
                    @endif
                </div> <!-- /widget-content -->
            </div> <!-- /widget -->

            <div class="widget">
                <div class="widget-header">
                    <i class="fa fa-flag"></i>
                    <span>{{__('Who Reported :count', ['count' => $comment->id])}}</span>
                </div> <!-- /widget-header -->
                <div class="widget-content">
                    @php($reports = $comment->reports()->limit(5)->get())
                    @if(count($reports))
                    @foreach($reports as $report)
                    @include('admin.pages._user_list_item', ['user' => $report->user, 'desc' =>
                    $report->created_at->diffForHumans()])
                    @endforeach
                    @else
                    {{__('Nothing to see here')}}
                    @endif
                </div> <!-- /widget-content -->
            </div> <!-- /widget -->
        </div>
    </div>
</div> <!-- /row -->

@endsection
@section('footer')
@endsection
