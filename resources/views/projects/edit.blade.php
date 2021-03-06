@extends('_layout.base')
@section('body')
    <body>
    @include('_layout.nav')
    <div id="main">
        <header>
            @if(Auth::user())
                <a class="signout action nofill green" href="/auth/logout"><i class="fa fa-sign-out"></i> Sign out</a>
                <div class="crumbtrail">
                    <a href="/">Home</a>
                    <i class="fa fa-angle-right"></i>
                    <a href="/clients">Clients</a>
                    <i class="fa fa-angle-right"></i>
                    <a href="/projects/{{ $project->client->stub }}/{{ $project->stub }}">{{ $project->name }}</a>
                    <i class="fa fa-angle-right"></i>
                    <a href="/projects/{{ $project->client->stub }}/{{ $project->stub }}/edit">Edit project</a>
                </div>
            @endif
            <h1>Edit project</h1>
        </header>
        <form action="" method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            @if(Auth::user()->rank == 3)
            <input name="hidden" type="checkbox" @if($project->public) checked @endif> Hidden from client?
            @endif

            <label>Project name</label>
            <input id="name" name="name" type="text" placeholder="e.g. Fire Safety" value="{{{ $project->name }}}" onkeyup="generateStub()" @if($errors->has('name')) class="error">
            <span class="error">{{ $errors->first('name') }}</span> @else > @endif

            <label>Project stub<em>(Used for URLs)</em></label>
            <input id="stub" name="stub" type="text" placeholder="e.g. firesafety" value="{{{ $project->stub }}}" @if($errors->has('stub')) class="error">
            <span class="error">{{ $errors->first('stub') }}</span> @else > @endif

            <label>Current version</label>
            <input name="current_version" type="text" placeholder="e.g. 1.0" value="{{{ $project->current_version }}}" @if($errors->has('current_version')) class="error">
            <span class="error">{{ $errors->first('current_version') }}</span> @else > @endif

            <label>Project status</label>
            <input name="status" type="text" placeholder="e.g. In development, Launched" value="{{{ $project->status }}}" @if($errors->has('status')) class="error">
            <span class="error">{{ $errors->first('status') }}</span> @else > @endif

            <label>Authoring Tool</label>
            <input name="authoring_tool" type="text" placeholder="e.g. Adapt, Storyline, Lectora" value="{{{ $project->authoring_tool }}}" @if($errors->has('authoring_tool')) class="error">
            <span class="error">{{ $errors->first('authoring_tool') }}</span> @else > @endif

            <hr/>

            <label>Deployment location</label>
            <input type="radio" name="lms_deployment" value="client" @if($project->lms_deployment == 'client') checked @endif> Client LMS
            <input type="radio" name="lms_deployment" value="sponge" @if($project->lms_deployment == 'sponge') checked @endif> Launch &amp; Learn
            <input type="radio" name="lms_deployment" value="none" @if($project->lms_deployment == 'none') checked @endif> Not applicable

            <label>LMS Specification</label>
            <input name="lms_specification" type="text" placeholder="e.g. SCORM 1.2, SCORM 2004" value="{{{ $project->lms_specification }}}" @if($errors->has('lms_specification')) class="error">
            <span class="error">{{ $errors->first('lms_specification') }}</span> @else > @endif

            <hr/>

            <label>Project manager</label>
            <input name="project_manager" type="text" placeholder="Start typing a name" value="{{{ $project->project_manager }}}" @if($errors->has('project_manager')) class="error">
            <span class="error">{{ $errors->first('project_manager') }}</span> @else > @endif

            <label>Lead developer</label>
            <input name="lead_developer" type="text" placeholder="Start typing a name" value="{{{ $project->lead_developer }}}" @if($errors->has('lead_developer')) class="error">
            <span class="error">{{ $errors->first('lead_developer') }}</span> @else > @endif

            <label>Lead designer</label>
            <input name="lead_designer" type="text" placeholder="Start typing a name" value="{{{ $project->lead_designer }}}" @if($errors->has('lead_designer')) class="error">
            <span class="error">{{ $errors->first('lead_designer') }}</span> @else > @endif

            <label>Instructional designer</label>
            <input name="instructional_designer" type="text" placeholder="Start typing a name" value="{{{ $project->instructional_designer }}}" @if($errors->has('instructional_designer')) class="error">
            <span class="error">{{ $errors->first('instrucitonal_designer') }}</span> @else > @endif

            <br/><button type="submit"><i class="fa fa-arrow-circle-right"></i> Update details</button>
            <a class="action red" href="javascript:history.back()"><i class="fa fa-times-circle"></i> Cancel</a>
        </form>
    </div>
@stop
