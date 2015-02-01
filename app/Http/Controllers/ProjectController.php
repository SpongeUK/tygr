<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use App\User;
use App\Group;
use App\Issue;
use Auth;
use Input;
use Session;

class ProjectController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $client_id = Auth::user()->client_id;
		$client = Client::where('id', '=', $client_id)->firstOrFail();
        return view('projects.index')->with('client', $client);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param  string  $stub
	 * @return Response
	 */
	public function create($stub)
	{
		$client = Client::where('stub', '=', $stub)->firstOrFail();
		return view('projects.create')->with('client', $client);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param string $stub
	 * @param CreateProjectRequest $request
	 * @return Response
	 */
	public function store($stub, CreateProjectRequest $request)
	{
		$client = Client::where('stub', '=', $stub)->firstOrFail();

		$project = new Project();
		$project->client_id					 = $client->id;
		$project->hidden 					 = Input::has('hidden');
		$project->name				         = $request->name;
		$project->stub				         = $request->stub;
		$project->current_version	         = $request->current_version;
		$project->status			         = $request->status;
		$project->authoring_tool             = $request->authoring_tool;
		$project->lms_deployment             = $request->lms_deployment;
		$project->lms_specification          = $request->lms_specification;
		$project->project_manager   		 = $request->project_manager;
		$project->lead_developer    		 = $request->lead_developer;
		$project->lead_designer     		 = $request->lead_designer;
		$project->instructional_designer     = $request->instructional_designer;

		$result = $project->save();
		if($result) {
			Session::flash('message', $project->name.' was created successfully.');
			return redirect('/clients/show/'.$stub);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $client
	 * @param  string  $stub
	 * @return Response
	 */
	public function show($client, $stub)
	{
		$client = Client::where('stub', '=', $client)->first();
		if(!$client) abort(404);

		$project = Project::where('client_id', '=', $client->id)
			->where('stub', '=', $stub)->first();
		if(!$project) abort(404);

		$userGroups = Auth::user()->groups->lists('id');
		$count = count(Issue::whereIn('assigned_to_id', $userGroups)
			->where('project_id', '=', $project->id)
			->where('status_id','!=','5')
			->get());

		return view('projects.show')->with('project', $project)->with('count', $count);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string  $client
	 * @param  string  $stub
	 * @return Response
	 */
	public function edit($client, $stub)
	{
		$client = Client::where('stub', '=', $client)->first();
		if(!$client) abort(404);

		$project = Project::where('client_id', '=', $client->id)
			->where('stub', '=', $stub)->first();
		if(!$project) abort(404);

		$employees = Group::find(2)->users()->get();

		return view('projects.edit')->with('project', $project)->with('employees', $employees);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string $client
	 * @param  string $stub
	 * @param UpdateProjectRequest $request
	 * @return Response
	 */
	public function update($client, $stub, UpdateProjectRequest $request)
	{
		$client = Client::where('stub', '=', $client)->first();
		if(!$client) abort(404);

		$project = Project::where('client_id', '=', $client->id)
			->where('stub', '=', $stub)->first();
		if(!$project) abort(404);

		$project->hidden 					 = Input::has('hidden');
		$project->name				         = $request->name;
		$project->stub				         = $request->stub;
		$project->current_version	         = $request->current_version;
		$project->status			         = $request->status;
		$project->authoring_tool             = $request->authoring_tool;
		$project->lms_deployment             = $request->lms_deployment;
		$project->lms_specification          = $request->lms_specification;
		$project->project_manager   		 = $request->project_manager;
		$project->lead_developer    		 = $request->lead_developer;
		$project->lead_designer     		 = $request->lead_designer;
		$project->instructional_designer     = $request->instructional_designer;
		$result = $project->save();

		if($result) {
			Session::flash('message', 'Project details updated successfully.');
			return redirect('/projects/'.$project->client->stub.'/'.$project->stub);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
