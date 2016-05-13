<?php

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('username');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamps();
		});

		Schema::create('sessions', function(Blueprint $table)
		{
			$table->string('id');
			$table->string('payload');
			$table->timestamp('last_activity');
		});

		User::create([
			'name' => 'AM Teacher',
			'username' => 'ammart',
			'email' => 'kru@ammart.ac.th',
			'password' => bcrypt('kru@ammart')
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('sessions');
	}

}
