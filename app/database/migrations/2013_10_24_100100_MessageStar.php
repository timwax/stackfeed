<?php

use Illuminate\Database\Migrations\Migration;

class MessageStar extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function($t){
			$t->boolean('stared', 0);

			$t->index('stared');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('messages', 'stared')){
			Schema::table('messages', function($t){
				$t->dropIndex('messages_stared_index');
			});		

			Schema::table('messages', function($t){
				$t->dropColumn('stared');
			});
		}

	}

}