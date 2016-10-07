<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionGroupsAliasAndParent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_groups', function (Blueprint $table) {
			$table->string('alias', 128)->after('label')->default('alias_not_set');
			$table->integer('parentID')->unsigned()->after('updated_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropColumn('question_groups', 'alias');
		Schema::dropColumn('question_groups', 'parentID');
	}

}
