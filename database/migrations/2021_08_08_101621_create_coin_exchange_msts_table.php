<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCoinExchangeMstsTable.
 */
class CreateCoinExchangeMstsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coin_exchange_msts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->decimal('coefficient', 10, 2);

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
		Schema::drop('coin_exchange_msts');
	}
}
