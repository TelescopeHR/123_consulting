<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Slug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\SlugTrait;

class QuireLessonsMigration extends Command
{
	use SlugTrait;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'migrate:quire_lessons';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate Quire Lessons into 123ConsultingSolutions.';

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
			$quire_lessons = DB::connection('mysql3')->table('lessons')->whereNull('deleted_at')->get();

			if (!$quire_lessons->isEmpty()) {
				foreach ($quire_lessons as $quire_lesson) {
					$quire_course = DB::connection('mysql3')->table('courses')->where('id', $quire_lesson->course_id)->whereNull('deleted_at')->first();
					if ($quire_course) {
						$course = Course::where('title', $quire_course->title)->first();
						if ($course) {
							$slug = $this->createUniqueSlug(Str::slug($quire_lesson->slug));
							$lesson = Lesson::create([
								'course_id' => $course->id,
								'title' => $quire_lesson->title,
								'description' => $quire_lesson->description,
								'video' => $quire_lesson->video,
								'order' => Lesson::where('course_id', $course->id)->count() + 1
							]);

							$slug_object = new Slug();
							$slug_object->slug = $slug;
							$lesson->slug_relation()->save($slug_object);
						}
					}
				}
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			dd($e->getMessage());
		}

		DB::rollBack();
	}
}
