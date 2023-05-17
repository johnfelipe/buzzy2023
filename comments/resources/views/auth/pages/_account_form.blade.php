<form action="{{$action}}" method="post" class="form-horizontal post_form" enctype="multipart/form-data" data-reload="yes">
   @if(isset($full_access))
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('User Type')}}</label>
        <div class="col-sm-10">
            <select id="user_type" name="user_type" class="form-control">
                <option value="admin" @if($user->user_type === 'admin') selected @endif>{{__('Admin')}}</option>
                <option value="mod" @if($user->user_type === 'mod') selected @endif>{{__('Mod')}}</option>
                <option value="banned" @if($user->user_type === 'banned') selected @endif>{{__('Banned')}}</option>
                <option value="" @if(!$user->user_type) selected @endif>{{__('Member')}}</option>
            </select>
        </div>
    </div>
    @endif
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Username')}}</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" placeholder="{{__('Username')}}" value="{{$user->username}}"/>
        </div>
    </div>
    @if(isset($full_access))
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Username Slug')}}</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="username_slug" name="username_slug" placeholder="{{__('Username Slug')}}" value="{{$user->username_slug}}"/>
        </div>
    </div>
    @endif
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Email')}}</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" placeholder="{{__('Email')}}" value="{{$user->email}}"/>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">{{__('Password')}}</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" placeholder="{{__('Password')}}" />
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="icon" class="col-sm-2 control-label">{{__('Icon')}}</label>
        <div class="col-sm-10">
            <img src="{{ image_url_create($user->icon, 'm', 'avatars') }}" width="150" height="150" class="profile-image" />
            <img src="{{ image_url_create($user->icon, 's', 'avatars') }}" width="60" height="60" class="profile-image" />
            <br>
            <input type="file" accept="image/*" id="icon" name="icon" />
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Full Name')}}</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" placeholder="{{__('Full Name')}}" value="{{$user->name}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('City')}}</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="city" name="city" placeholder="{{__('City')}}" value="{{$user->city}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Gender')}}</label>
        <div class="col-sm-10">
            <select id="gender" name="gender" class="form-control">
                @if($user->gender)
                <option value="{{$user->gender}}">{{$user->gender}} ({{__('Current')}})</option>
                @endif
                <option value="">---</option>
                <option value="Male">{{__('Male')}}</option>
                <option value="Female">{{__('Female')}}</option>
                <option value="Other">{{__('Other')}}</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Age')}}</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="age" name="age" placeholder="{{__('Age')}}" value="{{$user->age}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('Url')}}</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="url" name="url" placeholder="{{__('Url')}}" value="{{$user->url}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">{{__('About')}}</label>
        <div class="col-sm-10">
            <textarea class="form-control" id="about" name="about" placeholder="{{__('About')}}">{{$user->about}}</textarea>
        </div>
    </div>
    @include('auth.pages._recaptcha_script')
    <button type="submit" class="btn btn-primary pull-right">{{__('Save')}}</button>
</form>
