<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseQuiz;
use App\Models\CourseTag;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Slug;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Traits\SlugTrait;

class CourseController extends Controller
{
    use SlugTrait;
    public function __construct()
    {
        View::share('module', 'course');
    }

    public function ajax()
    {
        return Datatables::of(Course::with(['lessons', 'tags', 'categories'])->orderBy('order'))
            ->addIndexColumn()
            ->editColumn('image_div', function ($row) {
                $btn = '<a href="' . $row->full_image . '" target="_blank">';
                $btn .= '<img src="' . $row->full_image . '" class="img-thumbnail" width="150">';
                $btn .= '</a>';
                return $btn;
            })
            ->addColumn('price', function ($row) {
                return '$' . $row->price;
            })
            ->addColumn('lesson_count', function ($row) {
                return  count($row->lessons);
            })
            ->editColumn('is_active', function ($row) {
                return  '<a href="' . route('course.status', $row->id) . '">' . ($row->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>') . '</a>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('course.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('course.destroy', ['course' => $row->id]) . '">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';

                $course_categories = $row->categories->pluck('id')->toArray();
                if (!in_array(1, $course_categories)) {
                    $btn .= '<a href="' . route('course.reviews', ['course' => $row->id]) . '" class="btn text-warning">';
                    $btn .= '<i class="fa fa-star"></i>';
                    $btn .= '</a>';
                }

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action', 'image_div', 'is_active'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = Course::whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->count();
        $categories = Category::where('type', 'Course')->get();
        if ($course) {
            $categories = Category::where('id', '!=', 1)->where('type', 'Course')->get();
        }
        $quizzes = Quiz::get();
        $tags = Tag::get();
        return view('admin.course.create', compact('categories', 'tags', 'quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $file_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images/course/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $this->createUniqueSlug($slug);

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'tax' => $request->tax ?: null,
            'image' => $file_name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'is_in_fbt' => $request->is_in_fbt ? 1 : 0,
            'order' => Course::count() + 1
        ]);

        $slug_object = new Slug();
        $slug_object->slug = $slug;
        $course->slug_relation()->save($slug_object);

        $course->tags()->sync($request->tag_id);
        $course->categories()->sync($request->category_id);
        $course->quizzes()->sync($request->quiz_id);

        $subscription = Course::where('id', $course->id)->whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->first();
        if ($subscription) {
            $this->stripePlan($course);
        }

        return redirect()->route('course.index')->with(['success' => 'Course added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->where('id', $id)->count();
        $categories = Category::where('id', '!=', 1)->where('type', 'Course')->get();
        if ($course) {
            $categories = Category::where('type', 'Course')->get();
        }
        $quizzes = Quiz::get();
        $tags = Tag::get();
        $data = Course::with(['lessons', 'tags', 'categories'])->where('id', $id)->first();
        $courseTags = CourseTag::where('course_id', $id)->pluck('tag_id')->toArray();
        $courseCategories = CourseCategory::where('course_id', $id)->pluck('category_id')->toArray();
        $courseQuizzes = CourseQuiz::where('course_id', $id)->pluck('quiz_id')->toArray();
        return view('admin.course.create', compact('categories', 'tags', 'data', 'courseCategories', 'courseTags', 'quizzes', 'courseQuizzes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $id = $course->id;
        $file_name = $course->image;
        $old_order = $course->order;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images/course/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        $oldPrice = $course->price;

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        $slug_id = $course->slug_relation ? $course->slug_relation->id : 0;
        $slug = $this->createUniqueSlug($slug, $slug_id);

        $course = Course::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'tax' => $request->tax ?: null,
            'image' => $file_name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'is_in_fbt' => $request->is_in_fbt ? 1 : 0,
            'order' => $request->order,
        ]);

        $course = Course::where('id', $id)->first();
        $course->slug_relation()->updateOrCreate([], [
            'slug' => $slug
        ]);

        $course->tags()->sync($request->tag_id);
        $course->categories()->sync($request->category_id);
        $course->quizzes()->sync($request->quiz_id);

        $this->sortOrder($old_order > $request->order ? 'desc' : 'asc');

        $subscription = Course::where('id', $id)->whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->first();
        if ($subscription) {
            if ($oldPrice != $request->price) {
                $this->stripePlan($course, true);
            } else {
                $this->stripePlan($course);
            }
        }

        return redirect()->route('course.index')->with(['success' => 'Course updated successfully.']);
    }

    public function sortOrder($sort_by = 'asc')
    {
        $order = 0;
        $courses = Course::orderBy('order')
                ->orderBy('updated_at', $sort_by)
                ->get();
        foreach ($courses as $course) {
            $course->order = $order + 1;
            $course->save();
            $order++;
        }
    }

    public function stripePlan($course, $isPriceChanged = false)
    {
        $stripe_key = get_setting_value('stripe_key');
        $stripe_enviroment = get_setting_value('stripe_enviroment');

        if ($stripe_enviroment == 'test') {
            $product_id = $course->test_product_id;
            $plan_id = $course->test_plan_id;
        } else {
            $product_id = $course->live_product_id;
            $plan_id = $course->live_plan_id;
        }

        $stripe_key = $stripe_key ? $stripe_key : env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($stripe_key);

        if ($product_id) {
            $stripe->products->update(
                $product_id,
                [
                    "name" => $course->title
                ]
            );
        } else {
            $product = $stripe->products->create([
                'name' => $course->title,
            ]);
            $product_id = $product->id;
        }

        if ($stripe_enviroment == 'test') {
            $course->test_product_id = $product_id;
        } else {
            $course->live_product_id = $product_id;
        }

        if (!$plan_id || $isPriceChanged) {
            $plan = $stripe->plans->create([
                'amount' => ($course->price + $course->tax) * 100,
                'currency' => 'usd',
                'interval' => 'year',
                'product' => $product_id,
            ]);

            $plan_id = $plan->id;
            if ($stripe_enviroment == 'test') {
                $course->test_plan_id = $plan_id;
            } else {
                $course->live_plan_id = $plan_id;
            }
        }
        $course->save();
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course_categories = $course->categories->pluck('id')->toArray();
        $id = $course->id;

        if (!in_array(1, $course_categories)) {
            if (!$course->user_courses->isEmpty()) {
                Session::put('error', 'You can\'t delete the course, purchased by the user.');
            } else {
                Lesson::where('course_id', $id)->delete();
                CourseTag::where('course_id', $id)->delete();
                CourseCategory::where('course_id', $id)->delete();
                CourseQuiz::where('course_id', $id)->delete();
                $course->slug_relation()->delete();
                $course->delete();
                Session::put('success', 'Course deleted successfully.');
            }
        } else {
            Session::put('error', 'You can\'t delete this subscription course.');
        }
        return response()->json(['status' => true]);
    }

    public function courses()
    {
        $courses = Course::with(['tags', 'categories'])->where('is_active', 1)->latest()->get();
        return view('front.course.index', compact('courses'));
    }

    public function reviews(Request $request, Course $course)
    {
        if ($request->ajax()) {
            return Datatables::of($course->reviews)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    $btn = '-';
                    if ($row->user) {
                        $btn = $row->user->first_name . ' ' . $row->user->last_name . '<br>';
                        $btn .= '<a href="mailto:' . $row->user->email . '">' . $row->user->email . '</a>';
                    }
                    return $btn;
                })
                ->addColumn('ratings', function ($row) {
                    $average_ratings = 0;
                    if ($row->ratings) {
                        $ratings = 0;
                        $ratings_counts = $row->ratings->count();

                        foreach ($row->ratings as $rating) {
                            $ratings += $rating->ratings;
                        }

                        $average_ratings = $ratings / $ratings_counts;
                    }

                    return '<div class="ml-1 mb-3 d-flex course-ratings-box" data-average-ratings="' . $average_ratings . '"></div>';
                })
                ->addColumn('review', function ($row) {
                    $comment = '-';
                    if ($row->comment) {
                        $comment = '<p title="' . $row->comment . '">' . \Illuminate\Support\Str::limit($row->comment, 250, '...') . '</p>';
                    }
                    return $comment;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div style="display: flex;">';
                    $btn .= '<a href="javascript:void(0)" class="show-ratings" target-url="' . route('review.ratings', ['review' => $row->id]) . '">';
                    $btn .= 'Show ratings';
                    $btn .= '</a>';
                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action', 'user', 'review', 'ratings'])
                ->make(true);
        }
        return view('admin.course.reviews', compact('course'));
    }

    public function ratings(Request $request, Review $review)
    {
        if ($request->ajax()) {
            $ratings = Rating::where('review_id', $review->id)->get();
            $view = view('admin.course.ratings', compact('ratings', 'review'))->render();
            return response()->json(['status' => true, 'data' => $view]);
        }

        return response()->json("Invalid Request!");
    }

    public function status(Course $course)
    {
        $course->is_active = !$course->is_active;
        $course->save();
        return back()->with('message', 'Course status updated successfully.');
    }
}
