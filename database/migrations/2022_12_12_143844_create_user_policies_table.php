<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPoliciesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_policies', function (Blueprint $table)
		{
			$table->id();
			$table->bigInteger('order_id')->nullable();
			$table->unsignedInteger('user_id');
			$table->unsignedBigInteger('policy_manual_id');
			$table->dateTime('purchase_date');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('policy_manual_id')->references('id')->on('policy_manuals');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_policies');
	}
}
