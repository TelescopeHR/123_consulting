<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCourseQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_course_quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('caregiver_id');
            $table->integer('user_course_id');
            $table->integer('course_id');
            $table->integer('quiz_id');
            $table->longText('answers');
            $table->integer('score');
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
        Schema::dropIfExists('user_course_quiz_answers');
    }
}
