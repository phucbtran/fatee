<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePackagePriceMstsTable.
 */
class CreatePackagePriceMstsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('package_price_msts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->decimal('coin_quantity', 10, 0);
            $table->decimal('price', 10, 2);
            $table->decimal('sale_off', 3, 0);

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
		Schema::drop('package_price_msts');
	}
}
