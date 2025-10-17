<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Slug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\SlugTrait;

class QuireCoursesMigration extends Command
{
	use SlugTrait;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'migrate:quire_courses';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate Quire Courses into 123ConsultingSolutions.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		DB::beginTransaction();

		try {
			$quire_courses = DB::connection('mysql3')->table('courses')->whereNull('deleted_at')->get();

			$category = Category::where('name', 'Caregiver Classes')->first();
			$categories = $category ? [$category->id] : [0];
			$quizzes = [0];

			if (!$quire_courses->isEmpty()) {
				foreach ($quire_courses as $quire_course) {
					$quire_course_quizzes = DB::connection('mysql3')->table('course_quizzes')->where('course_id', $quire_course->id)->get()->pluck('quiz_id');
					if (!$quire_course_quizzes->isEmpty()) {
						$quire_quiz = DB::connection('mysql3')->table('quizzes')->whereIn('id', $quire_course_quizzes)->first();
						if ($quire_quiz) {
							$quiz = Quiz::where('title', $quire_quiz->title)->first();
							if ($quiz) {
								$quizzes = [$quiz->id];
								$slug = $this->createUniqueSlug(Str::slug($quire_course->slug));
								$course = Course::create([
									'title' => $quire_course->title,
									'description' => $quire_course->description,
									'price' => 20,
									'tax' => NULL,
									'image' => '',
									'order' => Course::count() + 1
								]);

								$slug_object = new Slug();
								$slug_object->slug = $slug;
								$course->slug_relation()->save($slug_object);

								$course->categories()->sync($categories);
								$course->quizzes()->sync($quizzes);
							}
						}
					}
				}
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			$this->line($e->getMessage());
		}

		DB::rollBack();
	}
}
