<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePaymentDtlsTable.
 */
class CreatePaymentDtlsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_dtls', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('user_msts');
            $table->unsignedInteger('id_package');
            $table->foreign('id_package')->references('id')->on('package_price_msts');
            $table->char('status', 1)->default('1')->comment('0:fail; 1:success');

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
		Schema::drop('payment_dtls');
	}
}
