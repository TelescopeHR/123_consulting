<?php

namespace App\Http\Controllers;

use App\Http\Requests\PolicyManualRequest;
use App\Models\Course;
use App\Models\PolicyManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Models\Slug;
use App\Traits\SlugTrait;

class PolicyManualController extends Controller
{
    use SlugTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        View::share('module', 'policy');
    }

    public function index()
    {
        return view('admin.policy.index');
    }

    public function ajax()
    {
        return Datatables::of(PolicyManual::with('course')->latest())
            ->addIndexColumn()
            ->editColumn('document', function ($row) {
                $btn = '<a href="' . asset('/policy-manual/' . $row->document) . '" target="_blank">';
                $btn .= '<i class="fa fa-file-image" aria-hidden="true"></i>';
                $btn .= '</a>';
                return $btn;
            })

            ->addColumn('price', function ($row) {
                return '$' . $row->price;
            })
            ->addColumn('tax', function ($row) {
                return  '$' . $row->tax;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('policy.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('policy.destroy', ['policy' => $row->id]) . '">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action', 'document'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$courses = Course::get();
        return view('admin.policy.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyManualRequest $request)
    {
        $file_name = '';
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $file_name = time() . '_' . $document->getClientOriginalName();
            $destinationPath = public_path('/policy-manual/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $document->move($destinationPath, $file_name);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $this->createUniqueSlug($slug);

        $policy = PolicyManual::create([
            'title' => $request->title,
            'price' => $request->price,
            'tax' => $request->tax,
            'document' => $file_name,
            'description' => $request->description,
            'is_in_fbt' => $request->is_in_fbt ? 1 : 0,
			'course_id' => $request->course_id ?? NULL,
        ]);

        $slug_object = new Slug();
        $slug_object->slug = $slug;
        $policy->slug_relation()->save($slug_object);

        return redirect()->route('policy.index')->with(['success' => 'Policy added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PolicyManual  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(PolicyManual $policy_manual)
    {
        return view('front.policy_manual.details', compact('policy_manual'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PolicyManual  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(PolicyManual $policy)
    {
        $data = $policy;
		$courses = Course::get();

        return view('admin.policy.create', compact('data', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PolicyManual  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(PolicyManualRequest $request, PolicyManual $policy)
    {
        $file_name = $policy->document;
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $file_name = time() . '_' . $document->getClientOriginalName();
            $destinationPath = public_path('/policy-manual/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $document->move($destinationPath, $file_name);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug_id = $policy->slug_relation ? $policy->slug_relation->id : 0;
        $slug = $this->createUniqueSlug($slug, $slug_id);

        $policy->update([
            'title' => $request->title,
            'price' => $request->price,
            'tax' => $request->tax,
            'document' => $file_name,
            'description' => $request->description,
            'is_in_fbt' => $request->is_in_fbt ? 1 : 0,
			'course_id' => $request->course_id ?? NULL,
        ]);

        $policy->slug_relation()->updateOrCreate([], [
            'slug' => $slug
        ]);

        return redirect()->route('policy.index')->with(['success' => 'Policy updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PolicyManual  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy(PolicyManual $policy)
    {
        $policy->slug_relation()->delete();
        $policy->delete();

        return response()->json(['status' => true]);
    }
}
