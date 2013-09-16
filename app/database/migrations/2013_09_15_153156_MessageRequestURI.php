<?php

use Illuminate\Database\Migrations\Migration;

class MessageRequestURI extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function($t){
			$t->text('meta');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('messages', function($t){
			$t->dropColumn('meta');
		});
	}

}