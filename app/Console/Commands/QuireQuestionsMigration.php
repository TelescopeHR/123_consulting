<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Traits\SlugTrait;

class QuireQuestionsMigration extends Command
{
	use SlugTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:quire_questions';

    /**
     * The console command description.
     *
     * @var string
     */
	protected $description = 'Migrate Quire Questions into 123ConsultingSolutions.';

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
			$quire_questions = DB::connection('mysql3')->table('questions')->whereNull('deleted_at')->get();

			if (!$quire_questions->isEmpty()) {
				foreach ($quire_questions as $quire_question) {
					$quire_quiz = DB::connection('mysql3')->table('quizzes')->where('id', $quire_question->quiz_id)->whereNull('deleted_at')->first();
					if ($quire_quiz) {
						$quiz = Quiz::where('title', $quire_quiz->title)->first();

						$question = Question::create([
							'quiz_id' => $quiz->id,
							'title' => $quire_question->title,
							'answer_type' => $quire_question->answer_type,
						]);

						$quire_question_answers = DB::connection('mysql3')->table('answers')->where('question_id', $quire_question->id)->whereNull('deleted_at')->get();

						if (!$quire_question_answers->isEmpty()) {
							foreach ($quire_question_answers as $quire_question_answer) {
								Answer::create([
									'question_id' => $question->id,
									'title' => $quire_question_answer->title,
									'is_true' => $quire_question_answer->is_true
								]);
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
