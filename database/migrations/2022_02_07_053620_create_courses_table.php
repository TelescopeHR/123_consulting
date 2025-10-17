<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
			$table->double('price');
            $table->string('image');
            $table->double('tax')->nullable();
            $table->text('description');
            $table->tinyInteger('is_in_fbt')->default(0)->comment('0.No, 1.Yes indicates course is in frequently bought together');
            $table->string('test_product_id')->nullable();
            $table->string('test_plan_id')->nullable();
            $table->string('live_product_id')->nullable();
            $table->string('live_plan_id')->nullable();
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
        Schema::dropIfExists('courses');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
