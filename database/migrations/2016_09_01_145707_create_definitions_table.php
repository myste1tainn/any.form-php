<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefinitionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('definitions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('tableName');
			$table->string('columnName');
			$table->string('values', 1024);
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
		Schema::drop('definitions');
	}

}
