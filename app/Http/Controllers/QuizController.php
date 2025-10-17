<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Certificate;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Slug;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Traits\SlugTrait;

class QuizController extends Controller
{
    use SlugTrait;

    public function __construct()
    {
        View::share('module', 'quiz');
    }

    public function ajax()
    {
        return Datatables::of(Quiz::with(['certificate'])->latest())
            ->addIndexColumn()
            ->addColumn('passing_score', function ($row) {
                return $row->passing_score . ' %';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('quiz.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('quiz.destroy', ['quiz' => $row->id]) . '">';
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
        return view('admin.quiz.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $certificates  = Certificate::all();
        return view('admin.quiz.create', compact('certificates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request)
    {
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $this->createUniqueSlug($slug);

        $quiz =  Quiz::create([
            'title' => $request->title,
            'passing_score' => $request->passing_score,
            'certificate_id' => $request->certificate_id,
            'description' => $request->description
        ]);

        $slug_object = new Slug();
        $slug_object->slug = $slug;
        $quiz->slug_relation()->save($slug_object);

        return redirect()->route('quiz.index')->with(['success' => 'Quiz added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificates = Certificate::all();
        $data = Quiz::where('id', $id)->first();
        return view('admin.quiz.create', compact('data', 'certificates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        $id = $quiz->id;
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug_id = $quiz->slug_relation ? $quiz->slug_relation->id : 0;
        $slug = $this->createUniqueSlug($slug, $slug_id);

        $quiz =  Quiz::where('id', $id)->update([
            'title' => $request->title,
            'passing_score' => $request->passing_score,
            'certificate_id' => $request->certificate_id,
            'description' => $request->description
        ]);
        $quiz = Quiz::where('id', $id)->first();
        $quiz->slug_relation()->updateOrCreate([], [
            'slug' => $slug
        ]);
        return redirect()->route('quiz.index')->with(['success' => 'Quiz updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        if ($quiz->courses->isEmpty()) {
            Question::where('quiz_id', $quiz->id)->delete();
            $quiz->slug_relation()->delete();
            $quiz->delete();
            Session::put('success', 'Quiz deleted successfully.');
            return response()->json(['status' => true]);
        }

        Session::put('error', 'You can\'t delete the quiz, which is assigned to courses.');
        return response()->json(['status' => true]);
    }
}
