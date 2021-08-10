<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateVideoCallDtlsTable.
 */
class CreateVideoCallDtlsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_call_dtls', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user_call');
            $table->foreign('id_user_call')->references('id')->on('user_msts');
            $table->unsignedInteger('id_user_receive');
            $table->foreign('id_user_receive')->references('id')->on('user_msts');
            $table->decimal('call_timing', 10)->comment('unit: seconds');
            $table->unsignedInteger('id_action_type');
            $table->foreign('id_action_type')->references('id')->on('action_type_msts');
            $table->char('rating', 1)->nullable();

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
		Schema::drop('video_call_dtls');
	}
}
