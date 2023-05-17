@if($user)
<div class="media">
    <div class="media-left">
        <a href="{{url('admin/users/'.$user->id)}}">
            <img class="media-object" src="{{image_url_create($user->icon, 's', 'avatars')}}" alt="{{$user->username}}">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading">{{$user->username}}</h4>
        <span style="font-size:11px;color:#ccc">{{$desc}}</span>
    </div>
</div>
@endif
