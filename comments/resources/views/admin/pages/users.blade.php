@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2 class="pull-left">
        <i class="fa fa-users red"></i>
        <span>{{__('Users')}}</span>

        @php($onlineCount = \App\User::where('last_seen', '>', \Carbon\Carbon::now()->subMinutes(30))->count())
       (<span style="color:green">{{__(':count Online', ['count' => $onlineCount])}}</span>)
        <span>-</span>
        <a href="{{ url('admin/users?user_type=admin')}}">
           <span style="color:grey;font-size:16px">
            {{__(':count Admins', ['count' => \App\User::byType('admin')->count()])}}
            </span>
        </a>
        <span>-</span>
        <a href="{{ url('admin/users?user_type=mod')}}">
           <span style="color:grey;font-size:16px">
            {{__(':count Mods', ['count' => \App\User::byType('mod')->count()])}}
            </span>
        </a>
        <span>-</span>
        <a href="{{ url('admin/users?user_type=banned')}}">
            <span style="color:grey;font-size:16px">
             {{__(':count Banned', ['count' => \App\User::byType('banned')->count()])}}
             </span>
         </a>
    </span>

    </h2>
    <div class="pull-right">
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th width="1%">{{__('#')}}</th>
                    <th width="20%">{{__('User')}}</th>
                    <th width="19%">{{__('Email')}}</th>
                    <th width="10%">{{__('Status')}}</th>
                    <th width="15%">{{__('Last Seen')}}</th>
                    <th width="15%">{{__('Joined At')}}</th>
                    <th width="20%" style="text-align:center">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th width="1%">{{__('#')}}</th>
                    <th width="20%">{{__('User')}}</th>
                    <th width="19%">{{__('Email')}}</th>
                    <th width="10%">{{__('Status')}}</th>
                    <th width="15%">{{__('Last Seen')}}</th>
                    <th width="15%">{{__('Joined At')}}</th>
                    <th width="20%" style="text-align:center">{{__('Actions')}}</th>
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@php($languages = get_datatable_languages())
@php($user_type = request()->query('user_type') ? '&user_type='. request()->query('user_type') : '')
@php($ajax_url = url('admin/users/data?type=users'.$user_type))

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#table').dataTable({
                order: [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                autoWidth: false,
                language: {!!json_encode($languages)!!},
                ajax: {
                    "url": '{!! $ajax_url !!}',
                    "data": function ( ) {
                        setTimeout(function(){   }, 2000);
                    }
                },
                columns: [
                    {sType: 'html', data: 'id', name: 'id', orderable: true, searchable: true},
                    {sType: 'html', data: 'user', name: 'username', orderable: false, searchable: true},
                    {sType: 'html', data: 'email', name: 'email', orderable: false, searchable: true},
                    {sType: 'html', data: 'status', name: 'last_seen', orderable: true, searchable: false},
                    {sType: 'html', data: 'last_seen', name: 'last_seen', orderable: true, searchable: true},
                    {sType: 'html', data: 'date', name: 'created_at', orderable: true, searchable: true},
                    {sType: 'html', data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });

    });
</script>
@endsection
