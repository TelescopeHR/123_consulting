<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonQuiz;
use App\Models\Quiz;
use App\Models\Slug;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Traits\SlugTrait;

class LessonController extends Controller
{
    use SlugTrait;

    public function __construct()
    {
        View::share('module', 'lesson');
    }

    public function ajax(Request $request)
    {
        $query = Lesson::select(['*']);
        if (isset($request->course_id)) {
            $query->where('course_id', $request->course_id)->orderBy('order');
        }
        $data = $query->whereHas('course')->with(['course'])->latest();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';              
                $btn .= '<a href="' . route('lesson.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger lesson-delete" data-id="' . $row->id . '" target-url="' . route('lesson.destroy', ['lesson' => $row->id]) . '">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';
                $btn .= '</div>';    
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lesson.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->put('lesson-previous-url', url()->previous());
        $courses = Course::get();
        $quizzes = Quiz::get();
        return view('admin.lesson.create', compact('courses', 'quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $this->createUniqueSlug($slug);

        $lesson = Lesson::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'video' => $request->video,
            'order' => Lesson::where('course_id', $request->course_id)->count() + 1
        ]);

        $slug_object = new Slug();
        $slug_object->slug = $slug;
        $lesson->slug_relation()->save($slug_object);

        if (session()->has('lesson-previous-url')) {
            return redirect()->to(session('lesson-previous-url'))->with(['success' => 'Lesson added successfully.']);
        }
        return redirect()->route('lesson.index')->with(['success' => 'Lesson added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session()->put('lesson-previous-url', url()->previous());
        $courses = Course::get();
        $data = Lesson::where('id', $id)->first();
        $quizzes = Quiz::get();
        $lessonQuizzes = LessonQuiz::where('lesson_id', $id)->pluck('quiz_id')->toArray();
        return view('admin.lesson.create', compact('courses', 'data', 'quizzes', 'lessonQuizzes'));
    }

    public function lessonDetail($id)
    {
        $data = Lesson::where('id', $id)->first();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug_id = $lesson->slug_relation ? $lesson->slug_relation->id : 0;
        $slug = $this->createUniqueSlug($slug, $slug_id);

        $old_order = $lesson->order;
        $lesson->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
            'video' => $request->video
        ]);

        $lesson = Lesson::find($lesson->id);
        $this->sortOrder($lesson, $old_order > $request->order ? 'desc' : 'asc');

        $lesson->slug_relation()->updateOrCreate([], [
            'slug' => $slug
        ]);

        if (session()->has('lesson-previous-url')) {
            return redirect()->to(session('lesson-previous-url'))->with(['success' => 'Lesson updated successfully.']);
        }
        return redirect()->route('lesson.index')->with(['success' => 'Lesson updated successfully.']);
    }

    function sortOrder($lesson, $sort_by = 'asc')
    {
        $order = 0;
        $lessons = Lesson::where('course_id', $lesson->course_id)
                ->orderBy('order')
                ->orderBy('updated_at', $sort_by)
                ->get();
        foreach ($lessons as $lesson1) {
            $lesson1->order = $order + 1;
            $lesson1->save();
            $order++;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        // $is_course_in_progress = UserCourse::where('course_id', $lesson->course->id)->where('is_completed', 0)->get();
        // if ($is_course_in_progress->isEmpty()) {
            $lesson->slug_relation()->delete();
            $lesson->delete();
        //     Session::put('success', 'Lesson deleted successfully.');
        // } else {
        //     Session::put('error', 'You can\'t delete lesson, as it\'s course is in-progess.');
        // }
        return response()->json(['status' => true]);
    }
}
