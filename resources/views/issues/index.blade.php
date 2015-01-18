@extends('layout.base')
@section('headlinks')
<script src="/js/list.min.js"></script>
@stop
@section('crumbtrail')
<a href="/"><li><i class="fa fa-home"></i> Home</li></a>
<a href="/projects"><li>Projects</li></a>
<a href="/projects/{{{ $project->stub }}}"><li>{{{ $project->name }}}</li></a>
<li class="current">Issues</li>
@stop
@section('body')
    <body>
    @include('layout.nav')
    <div id="main">
        @include('layout.header')
        <h1>All issues</h1>
        <div id="issues">
        <input class="filter search" placeholder="Search" autofocus/>
        <a class="action" href="/projects/{{ $project->stub }}/issues/create"><i class="fa fa-plus-circle"></i> New issue</a>
        <a class="action" href=""><i class="fa fa-bug"></i> All issues</a>
        <a class="action" href="{{ Request::url() }}/me"><i class="fa fa-check-square-o"></i> Assigned to me</a>

        <table class="full">
            <tr class="head">
                <th>Ref.</th>
                <th>Type</th>
                <th>Description</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <tbody class="list">
            @foreach($issues as $issue)
            <tr onclick="document.location='{{{ Request::url() }}}/show/{{{ $issue->id }}}';" style="cursor:pointer" @if($issue->status == 'Resolved') class="resolved" @endif
                    >
                <td class="reference">{{{ $issue->reference }}}</td>
                <td class="type">{{{ $issue->type }}}</td>
                <td class="description">{{{ substr($issue->description,0,72) }}}...</td>
                <td class="date">{{ date("m-d-y",strtotime($issue->created_at)) }}</td>
                <td class="priority {{ $issue->priority }}">{{{ $issue->status }}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <script>
            var options = { valueNames: ['reference', 'type', 'description', 'date'] };
            var userList = new List('issues', options);
        </script>
    </div>
</body>
@stop