@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2 class="pull-left">
        <i class="fa fa-users red"></i>
        <span>{{__('Pages')}}</span>
    </h2>
    <div class="pull-right">
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-header">
                <i class="fa fa-edit"></i>
                <span>{{$page? $page->title : __('Create Page')}}</span>
            </div>
            <div class="widget-content">

                <form action="{{$page ? url('admin/pages/'.$page->id) : url('admin/pages/create') }}" class="post_form" data-reload="yes" method="post">
                    <input name="type" id="type" type="hidden" value="{{$page? $page->type : 'page'}}">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label">{{__('Title')}}</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{$page? $page->title : ''}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('Content')}}</label>
                            <textarea class="form-control"  name="body" id="body" style="width:100%;height:400px">{{$page? $page->body : ''}}</textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                            <a class="btn" href="{{url('admin/pages/')}}" style="float:right">{{__('Cancel')}}</a>
                        </div> <!-- /form-actions -->
                    </fieldset>
                </form>

            </div>
        </div>
    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@endsection
