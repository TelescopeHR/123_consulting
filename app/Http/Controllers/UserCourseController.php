<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Mail\ReviewMail;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Rating;
use App\Models\Review;
use App\Models\ReviewQuestion;
use App\Models\Slug;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserCourseQuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Traits\GenerateCertificate;
use App\Traits\SendEmail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserCourseController extends Controller
{
    use GenerateCertificate, SendEmail;

    public function inProgress()
    {
        $user = Auth::user();

        $user_courses = UserCourse::where('is_completed', 0)->whereHas('course')->with('course');
        if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
            $user_courses = $user_courses->where('user_id', $user->id)->latest()->get();
        } elseif ($user->hasRole([Config::get('constants.users_roles.caregiver')])) {
            $user_courses = $user_courses->where('caregiver_id', $user->id)->latest()->get();
        } else {
            $user_courses = NULL;
        }

        return view('admin.user.courses.inprogress', compact('user_courses'));
    }


    public function course_details($course_slug)
    {
        $course = Slug::whereSlug($course_slug)->firstOrFail();
        $course = $course->sluggable;
        if (!$course->is_active) {
            abort(404);
        }
        $categories = $course && $course->categories ? $course->categories->pluck('id')->toArray() : [];
        $related_courses = Course::where('id', '!=', $course->id)->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('category_id', $categories);
        })->latest()->where('is_active', 1)->limit(3)->get();
        return view('front.course.details', compact('course', 'related_courses'));
    }

    public function user_course($id)
    {
        $user = Auth::user();
        $user_course = UserCourse::where('id', $id);

        if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
            $user_course = $user_course->where('user_id', $user->id)->firstOrFail();
        } elseif ($user->hasRole([Config::get('constants.users_roles.caregiver')])) {
            $user_course = $user_course->where('caregiver_id', $user->id)->firstOrFail();
        } else {
            $user_course = NULL;
        }

        if ($user_course) {
            $course_lessons = $user_course->course->lessons;
            $total_lessons = $course_lessons->count();
            if ($total_lessons) {
                $completed_lesson_ids_arr = $user_course->completed_lesson_ids ? explode(',', $user_course->completed_lesson_ids) : [];

                $active_lesson = $course_lessons->first();
                foreach ($course_lessons as $lesson) {
                    if (!in_array($lesson->id, $completed_lesson_ids_arr)) {
                        $active_lesson = $lesson;
                        break;
                    }
                }
            }
            $url = $total_lessons ? route('user.courses.lessons', [$user_course->course->slug_relation->slug, $active_lesson->slug_relation->slug]) : route('courses.details', [$user_course->course->slug_relation->slug]);

            Session::put('user_course_id', $user_course->id);

            return redirect($url);
        }
        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function courses_lessons(Request $request, $course_slug, $lesson_slug)
    {
        $user = Auth::user();

        $current_course = Slug::whereSlug($course_slug)->firstOrFail();
        $current_course = $current_course->sluggable;

        $current_lesson = Slug::whereSlug($lesson_slug)->firstOrFail();
        $current_lesson = $current_lesson->sluggable;

        $user_course_id = Session::has('user_course_id') ? Session::get('user_course_id') : 0;
        $user_course = UserCourse::findOrFail($user_course_id);

        $user_course->update([
            'last_active' => date('Y-m-d H:i:s')
        ]);

        $lessons = $current_course->lessons()->orderBy('order')->paginate(10);
        $lessonIds = $lessons->pluck('id')->toArray();
        if (!in_array($current_lesson->id, $lessonIds)) {
            $current_lesson = $lessons->first();

            if (!$request->ajax() && $request->get('page')) {
                $page = $request->get('page');
                $url = route('user.courses.lessons', [$current_course->slug_relation->slug, $current_lesson->slug_relation->slug]);
                $url = $page ? $url . '?page=' . $page : $url;
                return redirect($url);
            }
        }

        if ($request->ajax()) {
            $page = $request->get('page');

            $url = route('user.courses.lessons', [$current_course->slug_relation->slug, $current_lesson->slug_relation->slug]);
            $url = $page ? $url . '?page=' . $page : $url;
            return response()->json(['status' => true, 'data_url' => $url]);
        }

        return view('admin.user.courses.course-lessons', compact('user_course', 'lessons', 'current_course', 'current_lesson'));
    }


    public function userCourseStart(Request $request)
    {
        if (Auth::user()->hasRole([Config::get('constants.users_roles.customer')  . '|' . Config::get('constants.users_roles.caregiver')])) {
            UserCourse::where('id', $request->user_course_id)->update([
                'start_date' => date('Y-m-d H:i:s')
            ]);
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function userCourseLessonCompleted(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole([Config::get('constants.users_roles.customer')  . '|' . Config::get('constants.users_roles.caregiver')])) {
                $userCourse = UserCourse::with(['course.lessons'])->where('id', $request->user_course_id)->first();
                $userCoursesArr = explode(',', $userCourse->completed_lesson_ids);
                if (!in_array($request->lession_id, $userCoursesArr)) {
                    $userCourse->completed_lesson_ids = $userCourse->completed_lesson_ids ? $userCourse->completed_lesson_ids . ',' . $request->lession_id : $request->lession_id;
                    $userCourse->completed_lessons = count(explode(',', $userCourse->completed_lesson_ids));
                    $userCourse->save();
                }
                Session::put('success', 'Lesson completed successfully.');
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }
        return redirect()->back()->with('error', 'Invalid request!');
    }

    public function courses_quizzes(Request $request, $course_slug, $quiz_slug)
    {
        $user = Auth::user();

        $current_course = Slug::whereSlug($course_slug)->firstOrFail();
        $current_course = $current_course->sluggable;

        $current_quiz = Slug::whereSlug($quiz_slug)->firstOrFail();
        $current_quiz = $current_quiz->sluggable;

        $user_course_id = Session::has('user_course_id') ? Session::get('user_course_id') : 0;
        $user_course = UserCourse::findOrFail($user_course_id);

        $lessons = $current_course->lessons()->paginate(10);

        if ($request->ajax()) {
            $page = $request->get('page');
            $lessonIds = $lessons->pluck('id')->toArray();

            $active_lesson = $lessons->first();
            $url = route('user.courses.lessons', [$current_course->slug_relation->slug, $active_lesson->slug_relation->slug]);
            $url = $page ? $url . '?page=' . $page : $url;
            return response()->json(['status' => true, 'data_url' => $url]);
        }

        return view('admin.user.courses.course-quizzes', compact('user_course', 'lessons', 'current_course', 'current_quiz'));
    }

    public function store_quiz_answers(Request $request)
    {
        if ($request->get('question')) {
            $ans = [];
            $is_clear = 1;
            $passedCount = 0;
            $totalQuestion = 0;
            foreach ($request->question as $key => $questions) {
                $totalQuestion++;
                foreach ($questions as $ques) {
                    $arr = [
                        'question_id' => $request->question_id[$key][0],
                        'answer_id' => $ques,
                    ];
                    array_push($ans, $arr);
                }
                $question_id = $request->question_id[$key][0];
                $originAns = Answer::whereQuestionId($question_id)->whereIsTrue(1)->pluck('id')->toArray();
                if ($originAns != $questions) {
                    $is_clear = 0;
                } else {
                    $passedCount++;
                }
            }
            $percentage = ($passedCount / $totalQuestion) * 100;

            $user_course = UserCourse::with('course')->whereId($request->user_course_id)->first();
            $quizAns = UserCourseQuizAnswer::create([
                'caregiver_id' => $user_course->caregiver_id,
                'user_course_id' => $request->user_course_id,
                'course_id' => $request->course_id,
                'quiz_id' => $request->quiz_id,
                'answers' => json_encode($ans),
                'score' => $percentage
            ]);

            $quiz = Quiz::find($request->quiz_id);

            if ($percentage >= $quiz->passing_score) {

                // update course as completed
                $user_course->update([
                    'end_date' => date('Y-m-d H:i:s'),
                    'is_completed' => 1
                ]);

                // generate certificate
                $caregiver_name = $user_course->certificate_name ?? ($user_course->caregiver->first_name . ' ' . $user_course->caregiver->last_name);
                $certificate_file = $this->generatePdf($quiz->certificate, $caregiver_name, $user_course->course->title, date('F d, Y'));

                $user_course->update([
                    'certificate' => $certificate_file['preview_pdf'],
                ]);

                // send mail to admin for course completed
                $data = [
                    'certificate_name' => $caregiver_name,
                    'course_purchased' => $user_course->purchase_date->format('d M Y'),
                    'company_email' => $user_course->user->email,
                    'company_phone' => $user_course->user->phone,
                    'course_name' => $user_course->course->title,
                    'quiz_name' => $quiz->title,
                    'marks' => $percentage
                ];
                $this->sendCompleteCourseEmail($data);
            }
            $id = $quizAns->id;
            return redirect()->route('user.course.course-quiz-result', ['id' => $id, 'total_questions' => $totalQuestion, 'total_cleared' => $passedCount, 'score' => $percentage]);
        }
    }

    public function course_quiz_result(Request $request)
    {
        $ans = UserCourseQuizAnswer::with('user_course.course')->whereId($request->id)->first();
        $course = $ans->user_course->course;
        $questions = Question::with('answers')->whereQuizId($ans->quiz_id)->get()->toArray();
        $assignment_id = $ans->assignment_id;
        $givenAnswers = json_decode($ans->answers, true);
        $givenAnswers = array_column($givenAnswers, 'answer_id');
        $correctAns = [];
        foreach ($questions as $question) {
            foreach ($question['answers'] as $answer) {
                if ($answer['is_true'] == 1) {
                    $correctAns[] = $answer['id'];
                }
            }
        }
        $totalQuestion = $request->total_questions;
        $totalCleared = $request->total_cleared;
        $percentage = $request->score;
        $quiz = Quiz::find($ans->quiz_id);
        return view('admin.user.courses.course-quiz-result', compact('correctAns', 'totalCleared', 'percentage', 'totalQuestion', 'course', 'assignment_id', 'questions', 'givenAnswers', 'quiz'));
    }

    public function completed()
    {
        $user = Auth::user();

        $query = UserCourse::where('is_completed', 1);
        if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
            $query->where('user_id', $user->id);
        } else {
            $query->where('caregiver_id', $user->id);
        }
        $user_courses = $query->where('certificate', '!=', NULL)->with('course')->latest()->get();

        return view('admin.user.courses.completed', compact('user_courses'));
    }

    public function feedback_form(Request $request, $course_id)
    {
        $review_questions = ReviewQuestion::latest()->get();
        $course = Course::findOrFail($course_id);
        return view('admin.user.courses.feedback-form', compact('course', 'review_questions'));
    }

    public function submit_feedback(FeedbackRequest $request)
    {
        $user = Auth::user();
        $insert_records = [];
        DB::beginTransaction();

        try {
            $course = Course::find($request->course_id);
            $review = Review::create([
                'user_id' => $user->id,
                'course_id' => $request->course_id,
                'comment' => $request->comment
            ]);

            $total_ratings = 0;
            foreach ($request->ratings as $key_ratings => $ratings) {
                $insert_records[] = [
                    'review_id' => $review->id,
                    'review_question_id' => $key_ratings,
                    'ratings' => $ratings,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ];
                $total_ratings += $ratings;
            }

            $average_ratings = $total_ratings / count($request->ratings);

            Rating::insert($insert_records);

            $admin_user = User::whereHas('roles', function ($query) {
                return $query->where('name', Config::get('constants.users_roles.super_admin'));
            })->first();

            $data = [
                'admin_user' => $admin_user,
                'user' => $user,
                'course' => $course,
                'review' => $review,
                'average_ratings' => $average_ratings,
            ];

            try {
                Mail::to($admin_user->email)->send(new ReviewMail($data));
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
            DB::commit();

            return redirect()->route('user.certificates')->with('success', 'Your feedback has been recorded.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        DB::rollback();
        return redirect()->back()->with('error', 'Something went wrong!');
    }
}
