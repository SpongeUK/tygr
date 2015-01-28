<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues', function(Blueprint $table)
		{
			$table->increments('id');
			// Hidden from client
			$table->boolean('hidden');
            // Author
			$table->integer('author_id')->unsigned();
			$table->foreign('author_id')->references('id')->on('users');
            // Assigned to
			$table->integer('assigned_to_id')->unsigned()->nullable();
			$table->foreign('assigned_to_id')->references('id')->on('groups');
            // Project
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
            // Project version
			$table->string('version');
            // Page reference
			$table->string('reference');
            // Issue type
			$table->string('type');
            // Description
			$table->text('description');
            // Status
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('issue_status');
            // Priority
			$table->string('priority');
            // Timestamps
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('issues');
	}

}
