<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoursesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_courses', function (Blueprint $table) {
			$table->id();
            $table->bigInteger('order_id')->nullable();
			$table->unsignedInteger('user_id');
            $table->unsignedInteger('caregiver_id');
			$table->unsignedInteger('course_id');
			$table->integer('completed_lessons')->default(0);
			$table->dateTime('purchase_date');
			$table->dateTime('start_date')->nullable();
            $table->string('completed_lesson_ids')->nullable();
            $table->datetime('end_date')->nullable();
            $table->datetime('last_active')->nullable();
            $table->string('certificate')->nullable();
            $table->tinyInteger('is_completed')->default(0)->comment('1 for completed and 0 for not completed');
			$table->timestamps();
			$table->softDeletes();
			$table->foreign('course_id')->references('id')->on('courses');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('caregiver_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_courses');
	}
}
