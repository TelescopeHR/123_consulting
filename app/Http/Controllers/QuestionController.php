<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function __construct()
    {
        View::share('module', 'question');
    }

    public function ajax()
    {
        return Datatables::of(Question::with(['answers', 'quiz'])->latest())
            ->addIndexColumn()
            ->addColumn('correct_answers', function ($row) {
                $btn = '';
                foreach ($row->correct_answers as $correct_answer) {
                    $btn .= $correct_answer->title . '<br>';
                }
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('question.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('question.destroy', ['question' => $row->id]) . '">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['correct_answers', 'action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quizzes = Quiz::get();
        return view('admin.question.create', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $question = Question::create([
            'quiz_id' => $request->quiz_id,
            'title' => $request->title,
            'answer_type' => $request->answer_type,
        ]);

        foreach ($request->answer as $key => $answer) {
            if ($answer) {
                Answer::create([
                    'question_id' => $question->id,
                    'title' => $answer,
                    'is_true' => isset($request->is_true[$key]) ? 1 : 0
                ]);
            }
        }

        return redirect()->route('question.index')->with(['success' => 'Question added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quizzes = Quiz::get();
        $data = Question::with(['answers'])->where('id', $id)->first();
        return view('admin.question.create', compact('data', 'quizzes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        Question::where('id', $id)->update([
            'quiz_id' => $request->quiz_id,
            'title' => $request->title,
            'answer_type' => $request->answer_type
        ]);

        if (isset($request->oldanswer) && count($request->oldanswer)) {
            foreach ($request->oldanswer as $key => $oldanswer) {
                if ($oldanswer) {
                    Answer::where('id', $key)->update([
                        'title' => $oldanswer,
                        'is_true' => isset($request->oldis_true[$key]) ? 1 : 0
                    ]);
                }
            }
        }

        if (isset($request->answer) && count($request->answer)) {
            foreach ($request->answer as $key => $answer) {
                if ($answer) {
                    Answer::create([
                        'question_id' => $id,
                        'title' => $answer,
                        'is_true' => isset($request->is_true[$key]) ? 1 : 0
                    ]);
                }
            }
        }

        return redirect()->route('question.index')->with(['success' => 'Question updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // if ($question->quiz) {
        //     Session::put('error', 'You can\'t delete the quiz\'s question.');
        // } else {
            $id = $question->id;
            Answer::where('question_id', $id)->delete();
            Question::where('id', $id)->delete();
            Session::put('success', 'Question deleted successfully.');
        // }
        return response()->json(['status' => true]);
    }

    public function answerDestroy(Answer $answer)
    {
        $answer->delete();
        Session::put('success', 'Answer deleted successfully.');
        return response()->json(['status' => true]);
    }
}
