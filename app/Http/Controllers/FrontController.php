<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Blog;
use App\Models\User;
use App\Models\Slug;
use App\Models\State;
use App\Models\Course;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Category;
use App\Traits\SendEmail;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use App\Traits\MondayComTrait;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreIntakeFormRequest;
use App\Models\Media;
use App\Models\PolicyManual;
use App\Models\StripeResponse;
use App\Models\UserCourse;
use App\Models\Video;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use App\Models\IntakeForm;

class FrontController extends Controller
{
	use SendEmail, MondayComTrait;

	public function __construct()
	{
		$setting = Setting::first();
		View::share('settings', $setting);
	}

	public function googlewithlogin()
	{
		return Socialite::driver('google')->redirect();
	}

	public function callback()
	{
		try {
			$user = Socialite::driver('google')->user();
			$is_user = User::where('email', $user->getEmail())->first();
			$name = explode(' ', $user->getName());

			if (!$is_user) {
				$saveUser = User::create([
					'google_id' => $user->getId(),
					'first_name' => $name[0],
					'last_name' => $name[1],
					'email' => $user->getEmail(),
					'password' => Hash::make($user->getName() . '@' . $user->getId()),
					'status' => 1,
					'is_password_sent' => 1,
				]);

				// Create Stripe Customer
				$saveUser->createAsStripeCustomer([
					'name' => $name[0] . ' ' . $name[1],
					'email' => $user->getEmail()
				]);

				$saveUser->markEmailAsVerified();
				$role = Role::where(['name' => Config::get('constants.users_roles.customer')])->get();
				$saveUser->assignRole($role);
			} else {
				$saveUser = User::where('email',  $user->getEmail())->update([
					'google_id' => $user->getId(),
					'first_name' => $is_user->first_name != null ? $is_user->first_name : $name[0],
					'last_name' => $is_user->last_name != null ? $is_user->last_name : $name[1],
				]);
				$saveUser = User::where('email', $user->getEmail())->first();
			}
			Auth::loginUsingId($saveUser->id);

			$saveUser->update([
				'last_login' => date('Y-m-d h:i:s')
			]);

			if ($saveUser->hasRole([Config::get('constants.users_roles.customer')])) {
				$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
				if (!empty($session_cart_data)) {
					foreach ($session_cart_data as $key_cart_item => $cart_item) {
						$session_cart_data[$key_cart_item]['user_id'] = $saveUser->id;
					}
					Session::put('cart_data', $session_cart_data);
					Session::save();
				}
			}

			if ($saveUser->hasRole([Config::get('constants.users_roles.caregiver')]) && Session::has('cart_data')) {
				Session::put('error', "Caregivers cannot purchase course, please contact admin.");
			}

			if (Session::has('url')) {
				$url = Session::get('url');
				if (isset($url['intended'])) {
					return redirect($url['intended']);
				}
			}

			return redirect()->route('user.courses.in-progress');
		} catch (\Exception  $e) {
			return redirect()->route('login')->with('error', $e->getMessage());
		}
	}

	public function index()
	{
		$categories = Category::with(['courses'])->where('id', '!=', 1)->where('type', 'Course')->whereHas('courses')->get();
		$courses = !$categories->isEmpty() ?  $categories->first()->courses->take(9) : [];
		$subscription_course = $course = Course::whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->first();
		$policy_manuals = '';
		return view('front.home', compact('categories', 'courses', 'policy_manuals', 'subscription_course'));
	}

	public function homePolicies(Request $request)
	{
		$categories = Category::with(['courses'])->where('id', '!=', 1)->where('type', 'Course')->whereHas('courses')->get();
		$courses = !$categories->isEmpty() ?  $categories->first()->courses->take(9) : [];
		$policy_manuals = PolicyManual::latest()->take(9)->get();
		$subscription_course = $course = Course::whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->first();
		return view('front.home', compact('categories', 'courses', 'policy_manuals', 'subscription_course'));
	}

	public function homeCategory(Request $request, $slug)
	{
		$categories = Category::with(['courses'])->where('id', '!=', 1)->where('type', 'Course')->whereHas('courses')->get();
		$courses = !$categories->isEmpty() ?  $categories->first()->courses->take(9) : [];
		$subscription_course = $course = Course::whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->first();

		$slug = Slug::whereSlug($slug)->first();
		$selectedCategory = [];
		$policy_manuals = '';
		if ($slug && $slug->sluggable_type == 'App\Models\Category') {
			$selectedCategory = $slug->sluggable;
		}

		return view('front.home', compact('categories', 'selectedCategory', 'policy_manuals', 'courses', 'subscription_course'));
	}

	public function coursebycategory(Request $request, $id)
	{
		$coursesQuery = Course::whereHas('categories', function ($query) use ($id) {
			return $query->where('id', $id);
		});
        $coursesQuery->where('is_active', 1);
		if ($request->name) {
			$coursesQuery->where('title', $request->name);
		}

		$totalItems = $coursesQuery;

		$courses = $coursesQuery->orderBy('order')
			->paginate(9);

		$view = view('front.coursebycategory', compact('courses','totalItems'))->render();
		return response()->json(['data' => $view,'total_items' => $totalItems->count()]);
	}

	public function blog()
	{
		$featuredBlogs = Blog::where('status', 1)->where('is_premium', 1)->latest()->get();
		$categories = Category::whereHas('blogs')->with('blogs', function($query) {
			$query->where('is_premium', 0);
		})->get();
		return view('front.blog', compact('categories', 'featuredBlogs'));
	}

	public function video()
	{
		$videos = Video::latest()->get();
		return view('front.videos', compact('videos'));
	}

	public function blog_dev()
	{
		$topBlogs = Blog::where('status', 1)->latest()->get();
		return view('front.blog_dev', compact('topBlogs'));
	}

	public function blogDetail($slug)
	{
		$blog = Slug::whereSlug($slug)->firstOrFail();
		$blog = $blog->sluggable;
		if ($blog) {
			return view('front.blogDetail', compact('blog'));
		} else {
			return redirect()->route('front.resources')->with('warning', 'Blog not found');
		}
	}

	public function verifyUser($token)
	{
		$verifyUser = VerifyUser::with(['user'])->where('token', $token)->first();
		if (!empty($verifyUser)) {
			$user = $verifyUser->user;
			if (!empty($user) && !$user->email_verified_at) {
				$verifyUser->user->email_verified_at = date('Y-m-d h:i:s');
				$verifyUser->user->status = 1;
				$verifyUser->user->save();
				$status = "Your e-mail is verified. You can now login.";
				// send email
				if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
					$this->sendWelcomeEmail($user);
				}

				return redirect()->route('login')->with('success', $status);
			} else {
				$status = "Your e-mail is already verified.";
				return redirect()->route('login')->with('success', $status);
			}
		} else {
			return redirect()->route('login')->with('warning', "Sorry your email cannot be identified.");
		}
	}

	public function register(RegisterRequest $request)
	{
		try {
			$user = User::create([
				'agency_name' => $request->agency_name,
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'email' => $request->email,
				'phone' => $request->phone,
				'username' => strtolower($request->username),
				'password' => Hash::make($request->password),
				'is_password_sent' => 1,
				'license_type' => $request->license_type && count($request->license_type) ? implode(', ', $request->license_type) : null,
			]);

			$role = Role::updateOrCreate(['name' => Config::get('constants.users_roles.customer')]);
			$user->assignRole($role);

			VerifyUser::create([
				'user_id' => $user->id,
				'token' => sha1(time())
			]);

			// Add Data in Monday API
			$this->add($user);

			// Create Stripe Customer
			$user->createAsStripeCustomer([
				'name' => $request->first_name . ' ' . $request->last_name,
				'email' => $request->email
			]);

			// Send Email
			$this->sendVerifyEmail($user->email, $user);
			$this->agencySignUpEMail($user);
		} catch (Exception $e) {
			Log::info($e->getMessage());
			return redirect()->back()->with('error', $e->getMessage());
		}

		return redirect()->route('login')->with('success', "Registration Successfully, Please verify your email.");
	}

	public function storeContact(ContactRequest $request)
	{
		Contact::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'phone' => $request->get('phone'),
			'message' => $request->get('message')
		]);

		$this->sendContactEmail('info@123consultingsolutions.com', $request->name, $request->email, $request->phone, $request->message);

		return redirect()->back()->with(['success' => 'Thank you for contacting us.']);
	}

	public function blogByCategory($id)
	{
		$query = Blog::query();
		if ($id) {
			$query->whereHas('categories', function ($q) use ($id) {
				$q->whereIn('id', [$id]);
			});
		}
		$blogs = $query->where('status', 1)->latest()->get();
		$html = '';
		foreach ($blogs as $blog) {
			$html .= '<div class="blog-col">
				<article class="blog-block">
					<div class="blog-meta">';
			$html .= '<a class="blogshare" href="' . route('front.page', $blog->slug_relation->slug) . '" title="Share">
							<i class="fas fa-share-alt"></i>
						</a>
					</div>
					<h3>
						<a href="' . route('front.page', $blog->slug_relation->slug) . '" title="$blog->title">' . $blog->title . '</a>
					</h3>';
			if ($blog->author_name) {
				$html .= '<span>By ' . $blog->author_name . '</span><br>';
			}
			if ($blog->publish_date) {
				$html .= '<span>On ' . $blog->publish_date->format('m/d/Y') . '</span>';
			}
			$html .= '</article>
			</div>';
		}
		return response()->json(['status' => true, 'data' => $html]);
	}

	public function get_state(Request $request)
	{
		if ($request->ajax()) {
			$country_id = $request->country_id;
			$query = State::where('country_id', $country_id);
			if ($request->search) {
				$query->where('name', 'LIKE', '%' . $request->search . '%');
			}
			$states = $query->orderBy('name', 'ASC')->get();

			return response()->json($states, 200);
		}
	}

	public function myProfile()
	{
		$userprofile = Auth::user();
		$courses = Course::orderBy('order')->get();
		return view('front.myProfile', compact('userprofile', 'courses'));
	}

	public function inProgress()
	{
		$user = Auth::user();
		$query = UserCourse::with('course')->groupBy('course_id');
		if (Auth::user()->hasRole(Config::get('constants.users_roles.customer'))) {
			$user_courses = $query->where('user_id', $user->id);
		} else {
			$user_courses = $query->where('caregiver_id', $user->id);
		}
		$user_courses = $query->get();
		return view('admin.user.courses.inprogress', compact('user_courses'));
	}

	public function email_exists(Request $request)
	{
		$exists = true;
		if ($request->ajax()) {
			$exists = User::where('email', $request->email)->exists();
		}
		return response()->json(['status' => $exists]);
	}

	public function policiesCards(Request $request)
	{
		if ($request->name) {
			$policyQuery = PolicyManual::where('title', $request->name);
		} else {
			$policyQuery = PolicyManual::query();
		}
		$totalItems = $policyQuery;
		$policy_manuals = $policyQuery->latest()->paginate(9);

		$view = view('front.policy_manuals', compact('policy_manuals'))->render();
		return response()->json(['data' => $view,'total_items' => $totalItems->count()]);
	}

	public function thank_you(Request $request)
	{
		if ($request->has('order')) {
			$order_id = "#" . $request->order;
			$user = Auth::user();
			$order = StripeResponse::where('order_id', $order_id)->where('user_id', $user->id)->firstOrFail();
			$user_policies = [];
			$download_link = '';
			if (!$order->user_policies->isEmpty()) {
				$user_policies = $order->user_policies;
				if ($user_policies->count() == 1) {
					$document = $user_policies->first()->policy_manual->document;
					$download_link = asset('/policy-manual/' . $document);
				} elseif ($user_policies->count() > 1) {
					$zip = new \ZipArchive();
					$zip_file_name = 'Policies-' . time() . '.zip';
					if ($zip->open(public_path('policy-manual/' . $zip_file_name), \ZipArchive::CREATE) == TRUE) {
						foreach ($user_policies as $key_user_policy => $user_policy) {
							$policy = $user_policy->policy_manual->document;
							$zip->addFile(public_path('policy-manual/' . $user_policy->policy_manual->document), $user_policy->policy_manual->document);
						}
					}
					$zip->close();
					$download_link = asset('/policy-manual/' . $zip_file_name);
				}
			}

			return view('front.thank-you', compact('order', 'download_link'));
		}
	}

	public function blogForm(Request $request)
    {
        $media = Media::where('short_code', 'like', $request->file_id . '%')->first();

        $filepath = public_path('media-files/' . $media->file);
        return response()->download($filepath);
    }

	 public function show()
    {
        return view('front.intake_form');
    }

   public function store(StoreIntakeFormRequest $request)
	{
		$validated = $request->validated();
		$fileFields = [
			'logo' => 'images/logos/',
			'admin_resume_file' => 'images/',
			'admin_presurvey_file' => 'images/',
			'alt_admin_resume_file' => 'images/',
			'alt_admin_presurvey_file' => 'images/',
		];

		foreach ($fileFields as $field => $relativePath) {
			if ($request->hasFile($field)) {
				$file = $request->file($field);
				$fileName = time() . '_' . $file->getClientOriginalName();
				$destinationPath = public_path($relativePath);

				if (!file_exists($destinationPath)) {
					mkdir($destinationPath, 0777, true);
				}

				$file->move($destinationPath, $fileName);

				$validated[$field] = $relativePath . $fileName;
			}
		}

		IntakeForm::create($validated);

		return redirect()->back()->with('success', 'Intake form submitted successfully.');
	}

	
	public function startupProgram(Request $request)
	{
		$categories = Category::with(['courses'])->where('id', '!=', 1)->where('type', 'Course')->whereHas('courses')->get();
		$courses = !$categories->isEmpty() ?  $categories->first()->courses->take(9) : [];
		$policy_manuals = PolicyManual::latest()->take(9)->get();
		$subscription_course = $course = Course::whereHas('categories', function ($query) {
            $query->where('category_id', 1);
        })->first();
		return view('front.home', compact('categories', 'courses', 'policy_manuals', 'subscription_course'));
	}
}
