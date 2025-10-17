<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_responses', function (Blueprint $table) {
            $table->id();
            $table->text('cart_items')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('coupon_id')->nullable();
            $table->string('order_id');
            $table->integer('qty');
            $table->double('sub_total');
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->double('total_amount');
            $table->string('response_id');
            $table->string('invoice')->nullable();
            $table->string('type');
            $table->longText('stripe_response');
            $table->string('payment_status')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('stripe_responses');
    }
}
