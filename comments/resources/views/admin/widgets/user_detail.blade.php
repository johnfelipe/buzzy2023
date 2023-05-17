<div class="widget">
    <div class="widget-header">
        <i class="fa fa-tags"></i>
        <span>{{__('About')}}</span>
    </div> <!-- /widget-header -->
    <div class="widget-content">
        <ul class="list-unstyled">
            <li class="list-group-item d-flex">
                <i class="fa fa-user"></i>
                <span>{{__('Name')}}:</span>
                <strong>{{$user->name}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-asterisk"></i>
                <span>{{__('Email')}}:</span>
                <strong>{{$user->email}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-gift"></i>
                <span>{{__('Age')}}:</span>
                <strong>{{$user->age}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-map-marker"></i>
                <span>{{__('City')}}:</span>
                <strong>{{$user->city}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-envelope"></i>
                <span>{{__('Gender')}}:</span>
                <strong>{{$user->gender}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-globe"></i>
                <span>{{__('Url')}}:</span>
                <strong>{{$user->url}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-sign-in"></i>
                <span>{{__('Ip no')}}:</span>
                <strong>{{$user->ipno}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-sign-in"></i>
                <span>{{__('Registered')}}:</span>
                <strong>{{$user->last_seen && $user->last_seen->diffForHumans()}}</strong>
            </li>
            <li class="list-group-item d-flex">
                <i class="fa fa-user-times"></i>
                <span>{{__('Last Seen')}}:</span>
                <strong>{{$user->created_at->diffForHumans()}}</strong>
            </li>
        </ul>

        <style>.list-group-item i{width:15px;margin-right:0;color: #4ab6d5;margin-top:2px;text-align:center;}</style>

    </div> <!-- /widget-content -->
</div> <!-- /widget -->
