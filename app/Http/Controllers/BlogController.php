<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Category;
use App\Models\Slug;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\SlugTrait;

class BlogController extends Controller
{
    use SlugTrait;
    public function __construct()
    {
        View::share('module', 'blog');
    }

    public function ajax()
    {
        return Datatables::of(Blog::latest())
            ->addIndexColumn()
            ->editColumn('image_div', function ($row) {
                $btn = '<a href="' . $row->full_image . '" target="_blank">';
                $btn .= '<img src="' . $row->full_image . '" class="img-thumbnail" width="150">';
                $btn .= '</a>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('blog.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('blog.destroy', ['blog' => $row->id]) . '">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('status', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('blog.status', $row->id) . '" class="btn ' . ($row->status ? "text-success" : "text-danger") . '" title="' . ($row->status ? "Active" : "Inactive") . '">';
                if ($row->status) {
                    $btn .= '<i class="fa fa-check"></i>';
                } else {
                    $btn .= '<i class="fa fa-times"></i>';
                }
                $btn .= '</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('is_premium', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('blog.premium', $row->id) . '" class="btn ' . ($row->is_premium ? "text-success" : "text-danger") . '" title="' . ($row->is_premium ? "Showing On Top" : "Removed From Top") . '">';
                if ($row->is_premium) {
                    $btn .= '<i class="fa fa-check"></i>';
                } else {
                    $btn .= '<i class="fa fa-times"></i>';
                }
                $btn .= '</a>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action', 'image_div', 'status', 'is_premium'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('type', 'Blog')->get();
        $tags = Tag::get();
        return view('admin.blog.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $file_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/blog/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $this->createUniqueSlug($slug);

        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'author_name' => $request->author_name,
            'publish_date' => $request->publish_date ? Carbon::createFromFormat('m/d/Y', $request->publish_date)->format('Y-m-d') : null,
            'is_premium' => $request->is_premium ? 1 : 0,
            'image' => $file_name
        ]);

        $slug_object = new Slug();
        $slug_object->slug = $slug;
        $blog->slug_relation()->save($slug_object);

        $blog->tags()->sync($request->tag_id);
        $blog->categories()->sync($request->category_id);

        return redirect()->route('blog.index')->with(['success' => 'Blog added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('type', 'Blog')->get();
        $tags = Tag::get();
        $data = Blog::with(['tags', 'categories'])->where('id', $id)->first();
        $blogTags = BlogTag::where('blog_id', $id)->pluck('tag_id')->toArray();
        $blogCategories = BlogCategory::where('blog_id', $id)->pluck('category_id')->toArray();
        return view('admin.blog.create', compact('categories', 'tags', 'data', 'blogCategories', 'blogTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $id = $blog->id;
        $file_name = $blog->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/blog/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug_id = $blog->slug_relation ? $blog->slug_relation->id : 0;
        $slug = $this->createUniqueSlug($slug, $slug_id);

        $blog = Blog::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'author_name' => $request->author_name,
            'publish_date' => $request->publish_date ? Carbon::createFromFormat('m/d/Y', $request->publish_date)->format('Y-m-d') : null,
            'is_premium' => $request->is_premium ? 1 : 0,
            'image' => $file_name
        ]);

        $blog = Blog::where('id', $id)->first();
        $blog->slug_relation()->updateOrCreate([], [
            'slug' => $slug
        ]);

        $blog->tags()->sync($request->tag_id);
        $blog->categories()->sync($request->category_id);

        return redirect()->route('blog.index')->with(['success' => 'Blog updated successfully.']);
    }

    public function status($id)
    {
        $blog = Blog::where('id', $id)->first();
        $blog->status = !$blog->status;
        $blog->save();
        return redirect()->route('blog.index')->with(['success' => 'Status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $id = $blog->id;
        BlogTag::where('blog_id', $id)->delete();
        BlogCategory::where('blog_id', $id)->delete();
        $blog->slug_relation()->delete();
        $blog->delete();
        Session::put('success', 'Blog deleted successfully.');
        return response()->json(['status' => true]);
    }
}
