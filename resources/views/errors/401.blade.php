@extends('_layout.base')
@section('headlinks')
<!--script src="/js/your-custom-javascript.js"></script-->
@stop
@section('crumbtrail')
<a href="/"><li><i class="fa fa-home"></i> Dashboard</li></a>
@stop
@section('body')
    <body>
    @include('_layout.nav')
    <div id="main">
        @include('_layout.header')
        <h1>401</h1>
        <p>Unauthorised.</p>
    </div>
</body>
@stop
