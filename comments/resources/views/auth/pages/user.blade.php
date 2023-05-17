@extends('auth.app')
@section('title', $user->username)
@section('body_class', "white popup_full")
@section('head')
@endsection

@section('content')

 <!-- easyComment Content Div -->
 <div id="easyComment_Content"></div>

 <script type="text/javascript">
 var easyComment_ByUserID = '{{$user->id}}';
 var easyComment_Theme = 'Default';
 var easyComment_Domain = '{{url("/")}}';
 (function() {
     var EC = document.createElement('script');
     EC.type = 'text/javascript';
     EC.async = true;
     EC.src =  easyComment_Domain +  '/plugin/embed.js';
     (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(EC);
 })();
 </script>

@endsection
