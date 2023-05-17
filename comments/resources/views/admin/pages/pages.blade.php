@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2 style="margin:0">
        <i class="fa fa-flag red"></i>
        <span>{{__('Pages')}}</span>
    </h2>
    <div>
        <a class="btn btn-primary" href="{{url('/admin/pages/create')}}">{{__('New Page')}}</a>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th width="1%">{{__('#')}}</th>
                    <th width="29%">{{__('Title')}}</th>
                    <th width="30%">{{__('Content')}}</th>
                    <th width="15%">{{__('Type')}}</th>
                    <th width="15%">{{__('Date')}}</th>
                    <th width="10%" style="text-align:center">{{__('Actions')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th width="1%">{{__('#')}}</th>
                    <th width="29%">{{__('Title')}}</th>
                    <th width="30%">{{__('Content')}}</th>
                    <th width="15%">{{__('Type')}}</th>
                    <th width="15%">{{__('Date')}}</th>
                    <th width="10%" style="text-align:center">{{__('Actions')}}</th>
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@php($languages = get_datatable_languages())
@php($ajax_url = url('admin/pages/data?type=reports'))

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
                    {sType: 'html', data: 'title', name: 'title', orderable: false, searchable: true},
                    {sType: 'html', data: 'body', name: 'body', orderable: false, searchable: false},
                    {sType: 'html', data: 'type', name: 'type', orderable: false, searchable: false},
                    {sType: 'html', data: 'date', name: 'date', orderable: true, searchable: true},
                    {sType: 'html', data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });

    });
</script>
@endsection
