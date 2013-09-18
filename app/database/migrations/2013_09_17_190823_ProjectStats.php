<?php

use Illuminate\Database\Migrations\Migration;

class ProjectStats extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('projects', function($t){

			$t->integer('new_messages')->unsigned()->default(0);
			$t->integer('total_messages')->unsigned()->default(0);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('projects', function($t){
			$t->dropColumn(array('new_messages', 'total_messages'));
		});
	}

}