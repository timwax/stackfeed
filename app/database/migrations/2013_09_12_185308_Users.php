<?php

use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($t){
			$t->increments('id');

			$t->string('username', 50);
			$t->string('email', 255);

			$t->string('password', 64);
			$t->boolean('activated');
			$t->boolean('blocked');

			$t->timestamps();

			// Index

			$t->index(array('username', 'email'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}