<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('follows', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('target_user_id')->unsigned()->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('follows');
	}

}
