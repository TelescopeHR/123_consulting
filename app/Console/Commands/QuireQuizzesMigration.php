<?php

namespace App\Console\Commands;

use App\Models\Quiz;
use App\Models\Slug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\SlugTrait;

class QuireQuizzesMigration extends Command
{
	use SlugTrait;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'migrate:quire_quizzes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate Quire Quizzes into 123ConsultingSolutions.';

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
			$quire_quizzes = DB::connection('mysql3')->table('quizzes')->whereNull('deleted_at')->get();

			if (!$quire_quizzes->isEmpty()) {
				foreach ($quire_quizzes as $quire_quiz) {
					$slug = $this->createUniqueSlug(Str::slug($quire_quiz->title));
					$quiz =  Quiz::create([
						'title' => $quire_quiz->title,
						'passing_score' => 70,
						'certificate_id' => 6,
						'description' => $quire_quiz->description
					]);

					$slug_object = new Slug();
					$slug_object->slug = $slug;
					$quiz->slug_relation()->save($slug_object);
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
