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
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('level');
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
			'password' => bcrypt('kru@ammart'),
			'level' => 1
		]);

		User::create([
			'name' => 'Mysteltainn',
			'username' => 'myste1tainn',
			'email' => 'msyte1tainn.icez@gmail.com',
			'level' => 999,
			'password' => bcrypt('asdfjkl;')
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
