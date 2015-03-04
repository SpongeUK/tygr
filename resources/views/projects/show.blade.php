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
                </div>
            @endif
            <h1>{{ $project->name }}</h1>
        </header>
        <a class="action" href="{{ Request::url() }}/issues/create"><i class="fa fa-plus-circle"></i> Log an issue</a>
        @if(Auth::user()->rank <= 2)
            <a class="action green" href="{{ Request::url() }}/version"><i class="fa fa-flask"></i> New version</a>
            <a class="action yellow" href="{{ Request::url() }}/edit"><i class="fa fa-edit"></i> Edit project</a>
        @endif
        <a class="action blue" href="{{ Request::url() }}/issues"><i class="fa fa-bug"></i> View issues</a>
        <a class="action blue" href="http://reviewarea.co.uk/Secure/{{ $project->client->stub }}"><i class="fa fa-desktop"></i> Review area</a>
        <div class="info-box">
            <table>
                <tr><td><strong>Current version</strong></td><td>{{{ $project->current_version }}}</td></tr>
            </table>
            <hr/>
            <table>
                <tr><td><strong>Project manager</strong></td><td>{{{ $project->project_manager }}}</td></tr>
                <tr><td><strong>Lead developer</strong></td><td>{{{ $project->lead_developer }}}</td></tr>
                <tr><td><strong>Lead designer</strong></td><td>{{{ $project->lead_designer }}}</td></tr>
                <tr><td><strong>Instructional designer</strong></td><td>{{{ $project->instructional_designer }}}</td></tr>

            </table>
            <hr/>
            <table>
                <tr><td><strong>Authoring tool</strong></td><td>{{{ $project->authoring_tool }}}</td></tr>
                <tr><td><strong>LMS Deployment</strong></td><td>{{{ $project->lms_deployment }}}</td></tr>
                <tr><td><strong>Specification</strong></td><td>{{{ $project->lms_specification }}}</td></tr>
            </table>
        </div>
        <h2>You have {{ $count }} issues assigned to you!</h2>
        @if($count == 0)
            <p>You're up to date, and you have no issues assigned to you.</p>
        @else
            <p>You can <a href="{{ Request::url() }}/issues?filter=me">click here</a> to take a look at these issues.</p>
        @endif
    </div>
@stop
