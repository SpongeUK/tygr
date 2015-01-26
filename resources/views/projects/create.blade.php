@extends('_layout.base')
@section('headlinks')
    <script src="/js/helpers.js"></script>
@stop
@section('crumbtrail')
    <a href="/"><li><i class="fa fa-home"></i> Home</li></a>
    <a href="/clients"><li>Clients</li></a>
    <a href="/clients/show/{{{ $client->stub }}}"><li>{{{ $client->name }}}</li></a>
    <li class="current">Create project</li>
@stop
@section('body')
    <body>
    @include('_layout.nav')
    <div id="main">
        @include('_layout.header')
        <h1>Create project</h1>
        <form action="" method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <input name="public" type="checkbox" checked> Visible to client?

            <label>Project name</label>
            <input id="name" name="name" type="text" placeholder="e.g. Fire Safety" value="" onkeyup="generateStub()">

            <label>Project stub<em>(Used for URLs)</em></label>
            <input id="stub" name="stub" type="text" placeholder="e.g. firesafety" value="">

            <label>Current version</label>
            <input name="current_version" type="text" placeholder="e.g. Version 1" value="">

            <label>Project status</label>
            <input name="status" type="text" placeholder="e.g. In development, Launched" value="">

            <hr/>

            <label>Authoring Tool</label>
            <input name="authoring_tool" type="text" placeholder="e.g. Adapt, Storyline, Lectora" value="">

            <label>Deployment location</label>
            <input type="radio" name="lms_deployment" value="client"> Client
            <input type="radio" name="lms_deployment" value="sponge"> Launch &amp; Learn

            <label>LMS Specification</label>
            <input name="lms_specification" type="text" placeholder="e.g. SCORM 1.2, SCORM 2004" value="">

            <hr/>

            <label>Project manager</label>
            <input name="project_manager" type="text" placeholder="Start typing a name" value="">

            <label>Lead developer</label>
            <input name="lead_developer" type="text" placeholder="Start typing a name" value="">

            <label>Lead designer</label>
            <input name="lead_designer" type="text" placeholder="Start typing a name" value="">

            <label>Instructional designer</label>
            <input name="instructional_designer" type="text" placeholder="Start typing a name" value="">

            <br/><button type="submit"><i class="fa fa-arrow-circle-right"></i> Update details</button>
        </form>

    </div>
    </body>
@stop
