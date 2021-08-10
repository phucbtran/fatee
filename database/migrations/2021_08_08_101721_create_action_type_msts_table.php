<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateActionTypeMstsTable.
 */
class CreateActionTypeMstsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_type_msts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('action_type', 100);
            $table->decimal('coin_quantity', 10, 0);

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
		Schema::drop('action_type_msts');
	}
}
