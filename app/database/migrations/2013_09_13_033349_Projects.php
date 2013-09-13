<?php

use Illuminate\Database\Migrations\Migration;

class Projects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function($t){
			$t->increments('id');
			$t->string('public_id', 12)->unique(); // Random unique string
			$t->string('name', 100);
			$t->text('description');
			$t->string('domain', 1024); // domain name www.example.com
			
			$t->boolean('active'); // Accept feedback
			$t->integer('user_id')->unsigned();
			
			$t->timestamps();
			$t->index(['user_id', 'public_id', 'active']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}