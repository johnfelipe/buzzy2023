@extends('admin.app')

@section('head')
@endsection

@section('content')

<div class="page-header">
    <h2 class="pull-left">
        <i class="fa fa-language red"></i>
        <span>{{__('Translations')}}</span>
    </h2>
    <div class="pull-right">
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">

        <div class="widget ">
            <div class="widget-content">
                <div class="alert alert-info">
                    @php($languages = get_available_languages())
                    <div class="form-group clearfix">
                        <label class="control-label" for="translation_languages">{{__('Select language to edit.')}}</label>
                        <select name="languages" id="translation_languages" class="form-control">
                            @foreach($languages as $language)
                                <option value="{{url('/admin/translations/'.$language)}}" @if($locale === $language) selected @endif>{{$language}}</option>
                            @endforeach
                        </select>
                    </div> <!-- /form-group -->
                </div>
                @if(count($translations))
                <form action="{{url('/admin/translations/'.$locale)}}" method="post" class="post_form">
                    <fieldset>
                        @foreach($translations as $key => $translation)
                            @php($slug = \Illuminate\Support\Str::slug($translation))
                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4" for="{{$slug}}">{!!$key!!}</label>
                                <div class="controls col-sm-8">
                                    <input type="text" class="form-control" id="{{$slug}}" name="{{$slug}}" value="{{$translation}}">
                                </div> <!-- /controls -->
                            </div> <!-- /form-group -->
                            <hr/>
                        @endforeach

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                            <a class="btn" href="{{url('admin')}}" style="float:right">{{__('Cancel')}}</a>
                        </div> <!-- /form-actions -->
                    </fieldset>
                </form>
                @endif
            </div>
        </div>

    </div> <!-- /spa12 -->
</div> <!-- /row -->

@endsection
@section('footer')
@endsection
