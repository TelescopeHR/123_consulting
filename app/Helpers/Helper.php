<?php

use App\Models\Abandoned;
use App\Models\Course;
use App\Models\PolicyManual;
use App\Models\Setting;
use App\Models\StripeResponse;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPolicy;
use App\Models\UserSubscription;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

if (!function_exists('get_setting_value')) {
	function get_setting_value($name)
	{
		$value = Setting::where('name', $name)->first();
		return $value ?  $value->value : null;
	}
}

if (!function_exists('check_course_already_purchased')) {
	function check_course_already_purchased($id)
	{
		if (Auth::check()) {
			$userCourse = UserCourse::where('course_id', $id)->where('user_id', Auth::user()->id)->where('is_completed', 0)->first();
			$userSubscription = UserSubscription::where('user_id', Auth::user()->id)->first();
			return $userCourse || $userSubscription;
		}
		return false;
	}
}

if (!function_exists('check_course_in_cart')) {
	function check_course_in_cart($id)
	{
		$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
		$key = array_search($id, array_column($session_cart_data, 'course_id'));
		return $key !== FALSE;
	}
}

if (!function_exists('check_policy_in_cart')) {
	function check_policy_in_cart($id)
	{
		$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
		$key = array_search($id, array_column($session_cart_data, 'policy_manual_id'));
		return $key !== FALSE;
	}
}

if (!function_exists('generateUniqueOrderId')) {
	function generateUniqueOrderId()
	{
		$latestOrder = StripeResponse::latest()->first();
		return '#' . rand(1000, 9999) . ($latestOrder ? $latestOrder->id + 1 : 1) . str_pad(rand(100, 999), 3, STR_PAD_LEFT);
	}
}

if (!function_exists('check_policy_purchased')) {
	function check_policy_purchased($policy_manual_id)
	{
		if (Auth::check()) {
			$user = User::find(Auth::id());
			$user_id = $user->hasRole(Config::get('constants.users_roles.caregiver')) ? $user->parent_id : $user->id;
			return UserPolicy::where('policy_manual_id', $policy_manual_id)->where('user_id', $user_id)->first();
		}

		return FALSE;
	}
}

if (!function_exists('check_course_in_progress')) {
	function check_course_in_progress($course_id)
	{
		if (Auth::check()) {
			$user = User::find(Auth::id());
			if ($user->hasRole([Config::get('constants.users_roles.caregiver')])) {
				return UserCourse::where('is_completed', 0)->where('course_id', $course_id)->where('caregiver_id', $user->id)->first();
			}
		}

		return FALSE;
	}
}

if (!function_exists('cart_total_calculation')) {
	function cart_total_calculation()
	{
		$applied_coupon = session()->has('applied_coupon') ? session()->get('applied_coupon') : null;
		$session_cart_data = session()->has('cart_data') ? session()->get('cart_data') : [];

		$sub_total = 0;
		$total = 0;
		$discount = 0;
		$tax = 0;

		if (!empty($session_cart_data)) {
			foreach ($session_cart_data as $key_cart_item => $cart_item) {
				if (isset($cart_item['course'])) {
					$sub_total = $sub_total + $cart_item['course']->price * $cart_item['quantity'];
					$tax = $tax + $cart_item['course']->tax * $cart_item['quantity'];

					if (!empty($applied_coupon)) {
						if ($applied_coupon->type == 'percentage') {
							$discount = $discount + number_format($cart_item['course']->price * ($applied_coupon->value / 100) * $cart_item['quantity'], 2);
						} else {
							$discount = $discount + $applied_coupon->value * $cart_item['quantity'];
						}
					}
				} elseif (isset($cart_item['policy_manual'])) {
					$sub_total = $sub_total + $cart_item['policy_manual']->price * $cart_item['quantity'];
					$tax = $tax + $cart_item['policy_manual']->tax * $cart_item['quantity'];

					if (!empty($applied_coupon)) {
						if ($applied_coupon->type == 'percentage') {
							$discount = $discount + number_format($cart_item['policy_manual']->price * ($applied_coupon->value / 100) * $cart_item['quantity'], 2);
						} else {
							$discount = $discount + $applied_coupon->value * $cart_item['quantity'];
						}
					}
				}
			}

			$total = $sub_total + $tax;
			if (!empty($applied_coupon)) {
				$total = $total - $discount;
			}
		}

		return [
			'sub_total' => $sub_total,
			'total' => $total,
			'discount' => $discount,
			'tax' => $tax,
		];
	}
}

if (!function_exists('abandonedCart')) {
	function abandonedCart($course_id = null, $policy_manual_id = null, $status)
	{
		if ($course_id) {
			Abandoned::create([
				'ip' => request()->ip(),
				'user_id' => Auth::check() ? Auth::id() : null,
				'course_id' => $course_id,
				'status' => $status
			]);
			abandonedCartToMondayCom($course_id, $policy_manual_id, $status);
		}
		if ($policy_manual_id) {
			Abandoned::create([
				'ip' => request()->ip(),
				'user_id' => Auth::check() ? Auth::id() : null,
				'policy_manual_id' => $policy_manual_id,
				'status' => $status
			]);
			abandonedCartToMondayCom($course_id, $policy_manual_id, $status);
		}
		return true;
	}
}

if (!function_exists('abandonedCartToMondayCom')) {
	function abandonedCartToMondayCom($course_id = null, $policy_manual_id = null, $status)
	{
		$token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjE4NDg0MDcxMCwidWlkIjozMjE4MTc4OCwiaWFkIjoiMjAyMi0xMC0wN1QwNTozMjo1OC4wMDBaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6MTI4MjAwMDAsInJnbiI6InVzZTEifQ.y0Xuxgfg4sGRXulbDCsyNExiRzudcnMuQDpdGtz44Es';
		$board_id = '4057157189';
		$apiUrl = 'https://api.monday.com/v2';
		$headers = ['Content-Type: application/json', 'Authorization: ' . $token];
		$query = 'mutation ($myItemName: String!, $columnVals: JSON!) { create_item (board_id:' . $board_id . ', item_name:$myItemName, column_values:$columnVals) { id } }';

		$name = null;
		$email = null;
		$phone = null;
		if (Auth::check()) {
			$name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
			$email = Auth::user()->email;
			$phone = Auth::user()->phone;
		}
		if ($course_id) {
			$course = Course::find($course_id);
		}
		if ($policy_manual_id) {
			$course = PolicyManual::find($policy_manual_id);
		}

		$statusText = '';
		if ($status == 1) {
			$statusText = "Added to cart";
		}
		if ($status == 2) {
			$statusText = "Removed from cart";
		}
		if ($status == 3) {
			$statusText = "Go to Checkout";
		}
		if ($status == 4) {
			$statusText = "Purchased";
		}

		$vars = [
			'myItemName' => request()->ip(),
			'columnVals' => json_encode([
				'text8' => $name,
				'email4' => $email,
				'text9' => $phone,
				'text4' => $course->title,
				'date4' => ['date' => Carbon::now()->format('Y-m-d'), 'time' => Carbon::now()->format('H:i:s')],
				'status' => ['label' => $statusText],
			])
		];

		try {
			$data = @file_get_contents($apiUrl, false, stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => $headers,
					'content' => json_encode(['query' => $query, 'variables' => $vars])
				]
			]));

			return json_decode($data, true);
		} catch (\Exception $e) {
			Log::error($e->getMessage());
		}
	}
}

if (!function_exists('createInvoicePdf')) {
	function createInvoicePdf($user, $stripe_response)
	{
		$data = [
			'company_name' => $user->first_name . ' ' . $user->last_name,
			'company_email' => $user->email,
			'stripe_response' => json_decode($stripe_response->session_data),
			'sub_total' => $stripe_response->sub_total,
			'tax' => $stripe_response->tax,
			'discount' => $stripe_response->discount,
			'total_amount' => $stripe_response->total_amount
		];

		$file_name = str_replace('#', '', $stripe_response->order_id);
		$pdfDestinationPath = public_path('/pdfs/order_invoices/');

		if (!file_exists($pdfDestinationPath)) {
			mkdir($pdfDestinationPath, 0777, true);
		}

		$receipt = $file_name . ".pdf";
		$pdfFilePath = $pdfDestinationPath . $receipt;

		$pdf = Pdf::loadView('pdf.invoice', compact('data'))->setPaper('a4', 'landscape');
		$pdf->save($pdfFilePath);

		return $receipt;
	}
}
