@extends('_layout.base')
@section('headlinks')
@stop
@section('crumbtrail')
    <a href="/"><li><i class="fa fa-home"></i> Home</li></a>
    <a href="/projects"><li>Projects</li></a>
    <a href="/projects/{{ $project->client->stub }}/{{{ $project->stub }}}"><li>{{{ $project->name }}}</li></a>
    <a href="/projects/{{ $project->client->stub }}/{{{ $project->stub }}}/issues"><li>Issues</li></a>
    <li class="current">Create</li>
@stop
@section('body')
    <body>
    @include('_layout.nav')
    <div id="main">
        @include('_layout.header')
        <h1>Log an issue</h1>
        <form action="{{{ Request::url() }}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            @if(Auth::user()->rank != 3)
            <input name="hidden" type="checkbox"> Hidden from client?
            @endif

            <label>What type of issue is this?</label>
            <input name="type" type="text" placeholder="e.g. Bug, text amend, design" autofocus @if($errors->has('type')) class="error">
            <span class="error">{{ $errors->first('type') }}</span> @else > @endif

            <label>Where did this happen?</label>
            <input name="reference" type="text" placeholder="e.g. Page 7 or b-09" @if($errors->has('reference')) class="error">
            <span class="error">{{ $errors->first('reference') }}</span> @else > @endif

            <label>Describe the issue</label>
            <textarea name="description" class="large" placeholder="Please be as specific as you can, including details on how to reproduce the issue, browser (IE/Chrome) and operating system." @if($errors->has('description')) class="error" @endif></textarea>
            @if($errors->has('description')) <span class="error">{{ $errors->first('description') }}</span> @endif

            <label>Attachment (screenshot, document)</label>
            <input type="file" name="attachment" @if($errors->has('attachment')) class="error">
            <span class="error">{{ $errors->first('attachment') }}</span> @else > @endif

            <br/><button type="submit"><i class="fa fa-arrow-circle-right"></i> Log issue</button>
        </form>

    </div>
    </body>
@stop
