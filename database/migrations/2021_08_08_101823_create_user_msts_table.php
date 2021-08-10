<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserMstsTable.
 */
class CreateUserMstsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_msts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('email', 200)->unique();
            $table->string('username', 200);
            $table->string('password', 100);
            $table->char('gender', 1)->comment('0:male; 1:female; 2:N/A');
            $table->char('status', 1)->comment('0:inactive; 1:active');
            $table->decimal('coin_quantity', 10);
            $table->char('account_type', 1)->comment('0:normal; 1:standard; 2:pro');
            $table->char('role', 1)->comment('0:admin; 1:user');

            $table->softDeletes();
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
		Schema::drop('user_msts');
	}
}
