<div class="widget widget-nopad">
    <div class="widget-header">
        <i class="fa fa-list-alt"></i>
        <span>{{__("Lastest Comments")}}</span>
    </div>
    <!-- /widget-header -->
    <div class="widget-content" style="padding:15px">
        @php($comments = App\Comment::approved()->orderBy('created_at', 'DESC')->limit(5)->get())
        @if(count($comments))
        <ul class="messages_layout">
            @foreach($comments as $key => $comment)
            <li class="from_user @if($key%2) right @else left @endif" style="float:none;display:block">
                    <a href="{{$comment->userdata->admin_link}}" class="avatar">
                        <img width="55" src="{{$comment->userdata->icon}}"/>
                    </a>
                    <div class="message_wrap" style="float:none;display:block">
                        <span class="arrow"></span>
                        <div class="info">
                            <a href="" class="name">{{$comment->userdata->username}}</a>
                            <span class="time">{{$comment->created_at->diffForHumans()}}</span>
                            <div class="options_arrow">
                                <div class="dropdown pull-right">
                                    <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
                                        <i class=" fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                                        <li><a href="{{url('admin/comments/'.$comment->id)}}">
                                            <i class="fa fa-share-alt fa fa-large"></i> {{__('Edit')}}</a>
                                        </li>
                                        <li>
                                            <a onClick="return confirm('{{__('Do you realy want this?')}}');" data-reload="yes" class="do_action" href="{{url('admin/comments/'.$comment->id.'/destroy')}}">
                                                <i class=" fa fa-trash fa fa-large do_action"></i> {{__('Delete')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="text">{{$comment->comment}}</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
              </li>
            @endforeach

        </ul>
        @else
            <div style="padding:10px">{{__('Nothing to see here')}}</div>
        @endif
    </div>
</div><!-- /widget -->
