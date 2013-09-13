<?php

use Illuminate\Database\Migrations\Migration;

class Messages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function($t){
	
			$t->increments('id');
			$t->string('email', 255);
			$t->string('ip', 15); // xxx.xxx.xxx.xxx
			$t->string('protocal'); // http | http(s)
			$t->text('content');
			$t->text('selections');
			
			$t->timestamps();
			$t->integer('project_id')->unsigned();
			$t->integer('type')->unsigned(); // O - default
			
			$t->string('fullName', '100');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}