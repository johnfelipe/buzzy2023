<div class="widget widget-nopad">
    <div class="widget-header">
        <i class="fa fa-list-alt"></i>
        <span>{{__("Pending Comments")}}</span>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        @php($comments = \App\Comment::approved(0)->limit(5)->get())
        @if(count($comments))
        <table class="table table-striped table-bordered" style="margin-bottom:0">
            <thead>
              <tr>
                <th style="width:50%">{{__("Comment")}}</th>
                <th style="width:30%">{{__("User")}}</th>
                <th style="width:20%" class="td-actions">{{__("Actions")}}</th>
              </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{ substr($comment->comment, 0, 20) }}</td>
                    <td>
                        <a href="{{$comment->userdata->admin_link}}">
                            <img width="25" src="{{$comment->userdata->icon}}">
                            {{$comment->userdata->username}}
                        </a>
                    </td>
                    <td class="td-actions">
                        <a href="{{url('admin/comments/'.$comment->id)}}" class="btn btn-small btn-success" style="padding:1px 6px;">
                            <i class="btn-fa fa-only fa fa-edit"> </i>
                        </a>
                        <a href="{{url('admin/comments/'.$comment->id.'/approve')}}" data-reload="yes"  class="btn btn-primary btn-small do_action" style="padding:1px 6px;">
                            <i class="btn-fa fa-only fa fa-check-square-o"></i>
                        </a>
                        <a onClick="return confirm('{{__('Do you realy want this?')}}');" data-reload="yes" href="{{url('admin/comments/'.$comment->id.'/destroy')}}" class="btn btn-danger btn-small do_action" style="padding:1px 6px;">
                            <i class="btn-fa fa-only fa fa-remove"> </i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div style="padding:10px">{{__('Nothing to see here')}}</div>
        @endif
    </div>
</div><!-- /widget -->
