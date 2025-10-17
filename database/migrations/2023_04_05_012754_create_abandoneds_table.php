<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbandonedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abandoneds', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('policy_manual_id')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1 for added to cart, 2 for removed, 3 for checkout, 4 for purchased');
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
        Schema::dropIfExists('abandoneds');
    }
}
