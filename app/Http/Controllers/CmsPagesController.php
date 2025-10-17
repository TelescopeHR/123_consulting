<?php

namespace App\Http\Controllers;

use App\Http\Requests\CmsPageRequest;
use App\Models\Blog;
use App\Models\CmsPages;
use App\Models\PolicyManual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Slug;
use App\Traits\SlugTrait;
use Illuminate\Support\Facades\Session;

class CmsPagesController extends Controller
{
	use SlugTrait;

	public function __construct()
	{
		View::share('module', 'CMS Page');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.cms_pages.index');
	}

	/**
	 * @param Request $request
	 */
	public function ajax(Request $request)
	{
		if ($request->ajax()) {
			$data = CmsPages::latest()->get();

			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('slug', function ($row) {
					return $row->slug_relation ? $row->slug_relation->slug : NULL;
				})
				->addColumn('action', function ($row) {
					$btn = '<div style="display: flex;">';
					$btn .= '<a href="' . route('cms-page.edit', $row->id) . '" class="btn text-primary">';
					$btn .= '<i class="fa fa-edit"></i>';
					$btn .= '</a>';
					$btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('cms-page.destroy', ['cms_page' => $row->id]) . '">';
					$btn .= '<i class="fa fa-trash"></i>';
					$btn .= '</a>';
					$btn .= '</div>';

					return $btn;
				})
				->rawColumns(['slug', 'action'])
				->make(true);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.cms_pages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CmsPageRequest $request)
	{
		$slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
		$slug = $this->createUniqueSlug($slug);

		$cms_page = CmsPages::create([
			'name' => $request->name,
			'page_content' => $request->page_content,
			'meta_name' => $request->meta_name,
			'meta_title' => $request->meta_title,
			'meta_description' => $request->meta_description
		]);

		$slug_object = new Slug();
		$slug_object->slug = $slug;
		$cms_page->slug_relation()->save($slug_object);

		return redirect()->route('cms-page.index')->with(['success' => $request->name . ' CMS Page added successfully.']);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\CmsPages  $cmsPages
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CmsPages $cmsPage)
	{
		$data = $cmsPage;
		return view('admin.cms_pages.create', compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\CmsPages  $cmsPages
	 * @return \Illuminate\Http\Response
	 */
	public function update(CmsPageRequest $request, CmsPages $cmsPage)
	{
		$slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
		$slug_id = $cmsPage->slug_relation ? $cmsPage->slug_relation->id : 0;
		$slug = $this->createUniqueSlug($slug, $slug_id);

		$cmsPage->name = $request->name;
		$cmsPage->page_content = $request->page_content;
		$cmsPage->meta_name = $request->meta_name;
		$cmsPage->meta_title = $request->meta_title;
		$cmsPage->meta_description = $request->meta_description;
		$cmsPage->save();

		$cmsPage->slug_relation()->updateOrCreate([], [
			'slug' => $slug
		]);

		return redirect()->route('cms-page.index')->with(['success' => $request->name . ' CMS Page updated successfully.']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\CmsPages  $cmsPages
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(CmsPages $cmsPage)
	{
		$cmsPage->slug_relation()->delete();
		$cmsPage->delete();
		Session::put('success', 'CMS Page deleted successfully.');
		return response()->json(['status' => true]);
	}

	public function blogByCategory($slug)
	{
		$slug = Slug::whereSlug($slug)->first();
		if ($slug && $slug->sluggable_type == 'App\Models\Category') {
			$category = $slug->sluggable;
			$id = $slug->sluggable->id;

			$blogs = Blog::whereHas('categories', function ($q) use ($id) {
				$q->whereIn('id', [$id]);
			})->where('status', 1)->where('is_premium', 0)->latest()->get();

			return view('front.blog-category', compact('blogs', 'category'));
		}
		abort(404);
	}

	public function page($slg)
	{
		$slug = Slug::whereSlug($slg)->first();
		//  dump($slg);
		//  dd($slug);
		if ($slug && $slug->sluggable_type == 'App\Models\CmsPages') {
			$cmslist = $slug->sluggable;
			return view('front.cms', ['cmslist' => $cmslist]);
		} else if ($slug && $slug->sluggable_type == 'App\Models\Category' || $slg == 'policies') {
			if ($slg == 'policies') {
				$slug = Slug::whereSlug('policies')->first();
				$policy_manuals = PolicyManual::latest()->paginate();
				return view('front.policy_manual.index', compact('policy_manuals'));
			}
			$category = $slug->sluggable;
			$courses = $slug->sluggable->courses->where('is_active', 1);
			return view('front.course.index', compact('courses', 'category'));
		} else if ($slug && $slug->sluggable_type == 'App\Models\Blog') {
			$blog = $slug->sluggable;

			$shareUrl = route('front.page', $blog->slug_relation->slug);

			$shareUrl = urlencode(route('front.page', $blog->slug_relation->slug));
			$data['facebookUrl'] = "https://www.facebook.com/sharer/sharer.php?u={$shareUrl}";

			$shareText = urlencode($blog->title);
			$data['twitterUrl'] = "https://twitter.com/intent/tweet?url={$shareUrl}&text={$shareText}";

			$data['linkedInUrl'] = "https://www.linkedin.com/sharing/share-offsite/?url={$shareUrl}";

			$data['blog'] = $blog;

			return view('front.blogDetail', $data);
		} else if ($slug && $slug->sluggable_type == 'App\Models\PolicyManual') {
			$policy_manual = $slug->sluggable;
			return view('front.policy_manual.details', compact('policy_manual'));
		} else {
			abort(404);
		}
	}
}
