<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolicyManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_manuals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->double('price');
            $table->double('tax')->nullable();
            $table->string('document');
            $table->text('description');
            $table->tinyInteger('is_in_fbt')->default(0)->comment('0.No, 1.Yes indicates course is in frequently bought together');
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
        Schema::dropIfExists('policy_manuals');
    }
}
