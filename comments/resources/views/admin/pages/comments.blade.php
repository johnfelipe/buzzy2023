@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2>
        <i class="fa fa-comments red"></i>
        @if(request()->get('approve') === 'unapproved')
            <span>{{__('Unapproved Comments :count', ['count' => $unapprovedCount])}}</span>
        @else
            <span>{{__('Comments')}} ( <a href="{{url('/admin/comments?approve=unapproved')}}" style="color:green">{{__(':count Unapproved', ['count' => $unapprovedCount])}}</a> )</span>
        @endif
    </h2>
    <div>
        <div class="btn-group">
            <a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> {{ request()->query('domain') ?? __('All') }}</a>
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
            <ul class="dropdown-menu pull-right">
                <li><a href="{{url('admin/comments')}}">{{__('All')}}</a></li>
                @foreach (explode(",", env('ALLOWED_DOMAINS')) as $site)
                    @if (!empty($site))
                        <li><a href="{{url('admin/comments?domain='.$site)}}">{{ $site}}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
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
                    <th width="14%">{{__('Content')}}</th>
                    <th width="30%">{{__('Comment')}}</th>
                    <th width="20%">{{__('Date')}}</th>
                    <th width="15%" style="text-align:center">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th width="1%">{{__('#')}}</th>
                    <th width="20%">{{__('User')}}</th>
                    <th width="14%">{{__('Content')}}</th>
                    <th width="30%">{{__('Comment')}}</th>
                    <th width="20%">{{__('Date')}}</th>
                    <th width="15%" style="text-align:center">{{__('Actions')}}</th>
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@php($languages = get_datatable_languages())
@php($approve_url = request()->query('approve') === 'unapproved' ? '&approve=unapproved' : '')
@php($domain_url = request()->query('domain') ? '&domain='. request()->query('domain') : '')
@php($ajax_url = url('admin/comments/data?type=comments'. $approve_url . $domain_url))

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
                    {sType: 'html', data: 'user', name: 'user', orderable: false, searchable: false},
                    {sType: 'html', data: 'content', name: 'content', orderable: false, searchable: false},
                    {sType: 'html', data: 'comment', name: 'comment', orderable: false, searchable: true},
                    {sType: 'html', data: 'date', name: 'created_at', orderable: true, searchable: false},
                    {sType: 'html', data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });

    });
</script>
@endsection
