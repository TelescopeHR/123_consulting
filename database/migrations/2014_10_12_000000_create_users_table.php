<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('parent_id')->nullable();
			$table->string('agency_name');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('phone')->nullable();
			$table->string('username')->nullable();
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('zipcode')->nullable();
			$table->bigInteger('country_id')->nullable();
			$table->bigInteger('state')->nullable();
			$table->datetime('last_login')->nullable();
			$table->tinyInteger('status')->default(0)->comment('0 for inactive and 1 for active');
            $table->string('google_id')->unique()->nullable();
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}