<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('choices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('label')->nullable();
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->string('note')->nullable();
			$table->integer('value');
			$table->integer('questionID')->unsigned();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

			$table->foreign('questionID')
				  ->references('id')
				  ->on('questions')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('choices');
	}

}
