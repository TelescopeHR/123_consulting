<?php

namespace Database\Seeders;

use App\Models\ReviewQuestion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReviewQuestionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		ReviewQuestion::insert([
			[
				'id'         => 1,
				'question'   => 'What were your learning objectives?',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'id'         => 2,
				'question'   => 'How likely are you to recommend this course to a friend/colleague?',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'id'         => 3,
				'question'   => 'How did this course develop you professionally?',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'id'         => 4,
				'question'   => 'What did you like most / least in the course?',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'id'         => 5,
				'question'   => 'Which topics do you wish were more in-depth?',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'id'         => 6,
				'question'   => 'How would you describe quizzes in terms of question variety and covered topics?',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		]);
	}
}
