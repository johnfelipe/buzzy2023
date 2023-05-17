<div class="widget widget-nopad">
    <div class="widget-header">
        <i class="fa fa-list-alt"></i>
        <span>{{__("Today's Stats")}}</span>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">

    <div class="widget big-stats-container">
        <div class="widget-content">
        <h6 class="bigstats">{{__("A rich comment script for your website")}}</h6>
        <div id="big_stats" class="cf">
            @php($today_comments = App\Comment::where('created_at', '>', \Carbon\Carbon::yesterday())->count())
            <div class="stat">
                <i class="fa fa-comment"></i>
                <span class="value">{{$today_comments}}</span>
            </div>
            <!-- .stat -->

            @php($today_likes = App\Vote::likes()->where('created_at', '>', \Carbon\Carbon::yesterday())->count())
            <div class="stat">
                <i class="fa fa-thumbs-up"></i>
                <span class="value">{{$today_likes}}</span>
            </div>
            <!-- .stat -->

            @php($today_dislikes = App\Vote::dislikes()->where('created_at', '>', \Carbon\Carbon::yesterday())->count())
            <div class="stat">
                <i class="fa fa-thumbs-down"></i>
                <span class="value">{{$today_dislikes}}</span>
            </div>
            <!-- .stat -->

            @php($today_users = App\User::where('created_at', '>', \Carbon\Carbon::yesterday())->count())
            <div class="stat">
                <i class="fa fa-user"></i>
                <span class="value">{{$today_users}}+</span>
            </div>
            <!-- .stat -->
        </div>
        </div>
        <!-- /widget-content -->

    </div>
    </div>
</div>
<!-- /widget -->
