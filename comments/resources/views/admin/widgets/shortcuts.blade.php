
        <div class="widget widget-nopad">
            <div class="widget-header">
                <i class="fa fa-bookmark"></i>
                <span>{{__("Important Shortcuts")}}</span>
            </div>
            <!-- /widget-header -->
            <div class="widget-content" style="padding: 10px">

                <div class="shortcuts">
                    <a href="{{url('admin/settings')}}" class="shortcut">
                        <i class="shortcut-icon fa fa-cog"></i>
                        <span class="shortcut-label">{{__('App Settings')}}</span>
                    </a>
                    <a href="{{url('admin/themes')}}" class="shortcut">
                        <i class="shortcut-icon fa fa-asterisk"></i>
                        <span class="shortcut-label">{{__('Themes')}}</span>
                    </a>
                    <a href="{{url('admin/reports')}}" class="shortcut">
                        <i class="shortcut-icon fa fa-flag"></i>
                        <span class="shortcut-label">{{__('Reports')}}</span>
                    </a>
                    <a href="{{url('admin/comments')}}" class="shortcut">
                        <i class="shortcut-icon fa fa-comment"></i>
                        <span class="shortcut-label">{{__('Comments')}}</span>
                    </a>
                </div>

            </div>
        </div><!-- /widget -->
