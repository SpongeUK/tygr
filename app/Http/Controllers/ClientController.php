<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Project;
use Input;

class ClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clients = Client::all();

		return view('clients.index')->with('clients', $clients);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('clients.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateClientRequest $request
	 * @return Response
	 */
	public function store(CreateClientRequest $request)
	{
		$client = new Client();
		$client->name	= $request->name;
		$client->stub	= $request->stub;
		$client->type	= $request->type;
		$result = $client->save();
		if($result) {
			\Session::flash('message', $client->name.' was created successfully.');
			return redirect('/clients/show/'.$client->stub);
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
		$client = Client::where('stub', '=', $stub)->first();
		if(!$client) {
			abort(404);
		}

		return view('clients.show')->with('client', $client);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = Client::where('id', '=', $id)->firstOrFail();

		return view('clients.edit')->with('client', $client);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param UpdateClientRequest $request
	 * @return Response
	 */
	public function update($id, UpdateClientRequest $request)
	{
		$client = Client::where('id', '=', $id)->first();
		if(!$client) {
			abort(404);
		}
		if($client->name != $request->name) {
			$client->name	= $request->name;
		}
		if($client->stub != $request->stub) {
			$client->stub	= $request->stub;
		}
		$client->type	= $request->type;
		$result = $client->save();

		if($result) {
			\Session::flash('message', $client->name.' was updated successfully.');
			return redirect('/clients/show/'.$client->stub);
		}
	}

	/**
	 * Show confirmation for deletion of a resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$client = Client::where('id', '=', $id)->firstOrFail();

		return view ('clients.delete')->with('client', $client);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Client::destroy($id);

		\Session::flash('message', 'This client was removed successfully.');
		return redirect('/clients');
	}

}
