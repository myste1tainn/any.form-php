<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilterFormDataModel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questionaires', function (Blueprint $table) {
			$table->tinyInteger('type')->default(0)->after('header');
			$table->tinyInteger('level')->default(0)->after('header');
		});

		Schema::table('choices', function (Blueprint $table) {
			$table->integer('parentID')->unsigned()->nullable()->after('questionID');
			$table->integer('type')->default(0)->after('value');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questionaires', function (Blueprint $table) {
			$table->dropColumn('level');
			$table->dropColumn('type');
		});

		Schema::table('choices', function (Blueprint $table) {
			$table->dropColumn('parentID');
			$table->dropColumn('type');
		});
	}

}
