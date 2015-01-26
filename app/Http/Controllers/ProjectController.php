<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\Project;
use App\User;
use App\Group;
use App\Issue;
use Input;

class ProjectController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $client_id = \Auth::user()->client_id;
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
	 * @return Response
	 */
	public function store($stub)
	{
		$client = Client::where('stub', '=', $stub)->firstOrFail();

		$project = new Project();
		$project->client_id					 = $client->id;
		$project->public 					 = Input::has('public');
		$project->name				         = Input::get('name');
		$project->stub				         = Input::get('stub');
		$project->current_version	         = Input::get('current_version');
		$project->status			         = Input::get('status');
		$project->authoring_tool             = Input::get('authoring_tool');
		$project->lms_location               = Input::get('lms_location');
		$project->lms_specification          = Input::get('lms_specification');
		$project->project_manager   		 = Input::get('project_manager');
		$project->lead_developer    		 = Input::get('lead_developer');
		$project->lead_designer     		 = Input::get('lead_designer');
		$project->instructional_designer     = Input::get('instructional_designer');
		$project->authoring_tool             = Input::get('authoring_tool');
		$project->lms_location               = Input::get('lms_location');
		$project->lms_specification          = Input::get('lms_specification');

		$result = $project->save();
		if($result) {
			\Session::flash('message', $project->name.' was created successfully.');
			return redirect('/projects/'.$project->stub);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $stub
	 * @return Response
	 */
	public function show($stub)
	{
		$user = \Auth::user();
        $client = $user->client_id;
		$userGroups = $user->groups->lists('id');
		$count = count(Issue::whereIn('assigned_to_id', $userGroups)->get());

		if($client == 1) {
			$project = Project::where('stub', '=', $stub)
				->firstOrFail();
		} else {
			$project = Project::where('client_id', '=', $client)
				->where('stub', '=', $stub)
				->firstOrFail();
		}

		return view('projects.show')->with('project', $project)->with('count', $count);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string  $stub
	 * @return Response
	 */
	public function edit($stub)
	{
		$client = \Auth::user()->client_id;

		if($client == 1) {
			$project = Project::where('stub', '=', $stub)
				->firstOrFail();
		} else {
			$project = Project::where('client_id', '=', $client)
				->where('stub', '=', $stub)
				->firstOrFail();
		}

		$employees = Group::find(2)->users()->get();
		//dd($employees);
		//$employees = array();

		return view('projects.edit')->with('project', $project)->with('employees', $employees);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $stub
	 * @return Response
	 */
	public function update($stub)
	{
		$project = Project::where('stub', '=', $stub)->firstOrFail();
		$project->public 					 = Input::has('public');
		$project->name				         = Input::get('name');
		$project->stub				         = Input::get('stub');
		$project->current_version	         = Input::get('current_version');
		$project->status			         = Input::get('status');
		$project->authoring_tool             = Input::get('authoring_tool');
		$project->lms_deployment             = Input::get('lms_deployment');
		$project->lms_specification          = Input::get('lms_specification');
		$project->project_manager   		 = Input::get('project_manager');
		$project->lead_developer    		 = Input::get('lead_developer');
		$project->lead_designer     		 = Input::get('lead_designer');
		$project->instructional_designer     = Input::get('instructional_designer');
		$project->authoring_tool             = Input::get('authoring_tool');
		$project->lms_deployment             = Input::get('lms_deployment');
		$project->lms_specification          = Input::get('lms_specification');
		$result = $project->save();
		if($result) {
			\Session::flash('message', 'Project details updated successfully.');
			return redirect('/projects/'.$project->stub);
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
