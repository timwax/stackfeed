<?php

use Illuminate\Database\Migrations\Migration;

class MessageRead extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function($t){
			$t->integer('read_by')->unsigned();
			$t->timestamp('read')->nullable();
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
			$t->dropColumn(array('read_by', 'read'));
		});
	}

}