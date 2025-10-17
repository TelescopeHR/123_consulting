<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdInPolicyManualsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('policy_manuals', function (Blueprint $table) {
			$table->integer('course_id')->unsigned()->after('id')->nullable();
			$table->foreign('course_id')->references('id')->on('courses');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('policy_manuals', function (Blueprint $table) {
			$table->dropForeign(['course_id']);
			$table->dropColumn('course_id');
		});
	}
}
