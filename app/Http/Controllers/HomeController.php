<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponMailRequest;
use App\Mail\CouponMail;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Course;
use App\Models\Lead;
use App\Models\PolicyManual;
use App\Models\StripeResponse;
use App\Models\UserCourse;
use App\Models\UserPolicy;
use App\Traits\MondayComTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HomeController extends Controller
{
	use MondayComTrait;

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		$query = User::query();
		$roles = [];
		$dashboard = [];
		if (Auth::user()->hasRole([Config::get('constants.users_roles.super_admin')])) {
			$usersByMonth = User::role([Config::get('constants.users_roles.customer')])
				->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%M-%Y') new_date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
				->groupby('year', 'month')
				->get();

			$months = [];
			$user_count = [];
			foreach ($usersByMonth as $user) {
				$months[] = $user->new_date;
				$user_count[] = $user->data;
			}
			$months = json_encode($months);
			$user_count = json_encode($user_count);
			return view('admin.dashboard', compact('months', 'user_count'));
		} elseif (Auth::user()->hasRole([Config::get('constants.users_roles.customer')])) {
			$user = Auth::user();
			$completed_courses = 0;
			$in_progress_courses = UserCourse::where('user_id', $user->id)->where('is_completed', 0)->whereHas('course')->count();
			$certificates = UserCourse::where('user_id', $user->id)->where('certificate', '!=', NULL)->whereHas('course')->count();
			$policies = UserPolicy::where('user_id', $user->id)->whereHas('policy_manual')->count();
			$user_courses = UserCourse::where('user_id', $user->id)->where('is_completed', 0)->get();

			return view('admin.dashboard', compact('in_progress_courses', 'completed_courses', 'certificates', 'policies'));
		} elseif (Auth::user()->hasRole([Config::get('constants.users_roles.caregiver')])) {
			$user = Auth::user();
			$completed_courses = 0;
			$in_progress_courses = UserCourse::where('caregiver_id', $user->id)->where('is_completed', 0)->whereHas('course')->count();
			$certificates = UserCourse::where('caregiver_id', $user->id)->where('certificate', '!=', NULL)->whereHas('course')->count();
			$policies = UserPolicy::where('user_id', $user->parent_id)->whereHas('policy_manual')->count();
			$user_courses = UserCourse::where('caregiver_id', $user->id)->where('is_completed', 0)->get();

			return view('admin.dashboard', compact('in_progress_courses', 'completed_courses', 'certificates', 'policies'));
		}
		return view('admin.dashboard');
	}

	public function virtualLogin(User $id)
	{
		$currentUser = auth()->user();
		$previousUsers = session()->get('previousUsers') ?: [];
		$previousUsers[] = $currentUser;
		Auth::login($id);
		$user = User::find(Auth::id());

		if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
			if (!empty($session_cart_data)) {
				foreach ($session_cart_data as $key_cart_item => $cart_item) {
					$session_cart_data[$key_cart_item]['user_id'] = $user->id;
				}
				Session::put('cart_data', $session_cart_data);
			}
		}

		session()->put('previousUsers', $previousUsers);
		Session::save();
		return redirect()->route('admin.dashboard');
	}

	public function slugCreate(Request $request)
	{
		$slug = Str::slug($request->title);
		return response()->json(['status' => true, 'data' => $slug]);
	}

	public function courseSearch(Request $request)
	{
		$courses = Course::select("title as value", "id")
			->whereHas('categories', function ($query) use ($request) {
				return $query->where('id', $request->category);
			})
			->where('title', 'LIKE', '%' . $request->search . '%')
			->orderBy('order')
			->get();

		return response()->json($courses);
	}

	public function policySearch(Request $request)
	{
		$policies = PolicyManual::select("title as value", "id")
			->where('title', 'LIKE', '%' . $request->search . '%')
			->latest()
			->get();

		return response()->json($policies);
	}

	public function popupClosed()
	{
		session()->put('popup-closed', true);
		return response()->json(['status' => true]);
	}

	public function email_coupon(CouponMailRequest $request)
	{
		$coupon = Coupon::whereId(1)->firstOrFail();
		$user = User::where('email', $request->offer_email)->first();

		if ($request->source == 'coupon' && $user) {
			$coupon_applied = StripeResponse::where('user_id', $user->id)->where('coupon_id', 1)->where('payment_status', 'paid')->first();

			if ($coupon_applied) {
				return redirect()->back()->with('error',  'You have already claimed this coupon code.');
			}
		}

		$leadDoesntExist = Lead::where('email', $request->offer_email)->doesntExist();
		if ($leadDoesntExist) {
			Lead::create([
				'email' => $request->offer_email,
				'phone' => $request->offer_phone,
				'source' => $request->source
			]);

			// add to monday com
			$this->addLeadToMonday([
				'email' => $request->offer_email,
				'source' => $request->source
			]);
		}

		if ($request->source == 'policy') {
			$policy_manual = PolicyManual::find($request->policy_id);
			if ($policy_manual) {
				$url = public_path('policy-manual/' . $policy_manual->document);
				session()->flash('download.in.the.next.request', $request->policy_id);
				return redirect()->back()->with('success', 'Your policy will be downloaded.');
			} else {
				return redirect()->back()->with('error', 'File not found.');
			}
		}

		if ($request->source == 'coupon') {
			try {
				Mail::to($request->offer_email)->send(new CouponMail($coupon->code));
			} catch (Exception $e) {
				Log::info($e->getMessage());
			}
		}

        return redirect()->back()->with('success', 'Coupon code has been sent to email.');
	}

	public function downloadPolicy($policy_id)
	{
		$policy_manual = PolicyManual::find($policy_id);
		$url = public_path('policy-manual/' . $policy_manual->document);
		if ($url && file_exists($url)) {
			return response()->download($url);
		}
		return redirect()->back()->with('error', 'File not found.');
	}
}
