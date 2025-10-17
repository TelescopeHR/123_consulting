<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Slug;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\SlugTrait;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use SlugTrait;

    public $types = [
        'Course',
        'Blog'
    ];

    public function __construct()
    {
        View::share('module', 'category');
    }

    public function ajax()
    {
        return Datatables::of(Category::with('slug_relation')->latest())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('category.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                if ($row->id != 1) {
                    $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('category.destroy', ['category' => $row->id]) . '">';
                    $btn .= '<i class="fa fa-trash"></i>';
                    $btn .= '</a>';
                }
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
        $types = $this->types;
        return view('admin.category.index', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $slug = $this->createUniqueSlug($slug);

        $category = Category::create([
            'name' => $request->name,
            'type' => $request->type
        ]);

        $slug_object = new Slug();
        $slug_object->slug = $slug;
        $category->slug_relation()->save($slug_object);

        return redirect()->route('category.index')->with(['success' => 'Category added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Category::find($id);
        $types = $this->types;
        return view('admin.category.index', compact('data', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $slug_id = $category->slug_relation ? $category->slug_relation->id : 0;
        $slug = $this->createUniqueSlug($slug, $slug_id);

        $category->update([
            'name' => $request->name,
            'type' => $request->type
        ]);

        $category->slug_relation()->updateOrCreate([], [
            'slug' => $slug
        ]);

        return redirect()->route('category.index')->with(['success' => 'Category updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->id == 1) {
            Session::put('error', 'You can\'t delete this caregory.');
        } else {
            if (!$category->courses->isEmpty()) {
                Session::put('error', 'You can\'t delete this category, as it is assigned to courses.');
            } elseif (!$category->blogs->isEmpty()) {
                Session::put('error', 'You can\'t delete this category, as it is assigned to blogs.');
            } else {
                $category->slug_relation()->delete();
                $category->delete();
                Session::put('success', 'Category deleted successfully.');
            }
        }
        return response()->json(['status' => true]);
    }
}
