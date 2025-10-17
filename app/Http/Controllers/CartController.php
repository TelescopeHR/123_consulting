<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Mail\InvoiceMail;
use App\Models\CartHelp;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\PolicyManual;
use App\Models\StripeResponse;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserPolicy;
use App\Models\UserSubscription;
use App\Models\VerifyUser;
use App\Traits\SendEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;
use Spatie\Permission\Models\Role;

class CartController extends Controller
{
	use SendEmail;

	/**
	 * @param Request $request
	 */
	public function index(Request $request)
	{
		$allow = TRUE;
		if (Auth::check()) {
			$allow = FALSE;
			$user = User::find(Auth::id());
			if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
				$allow = TRUE;
			}
		}

		if ($allow == TRUE) {
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
			$session_cart_help = Session::has('cart_help') ? Session::get('cart_help') : [];
			$cartData = [];

			$download_url = '';
			$applied_coupon = session()->has('applied_coupon') ? session()->get('applied_coupon') : null;

			if (!empty($session_cart_data)) {
				foreach ($session_cart_data as $key_cart_item => $cart_item) {
					$cart_item['id'] = $key_cart_item;
					$cartData[] = $cart_item;
					if (isset($cart_item['policy_manual_id']) && isset($cart_item['policy_manual']) && $cart_item['policy_manual'] && $cart_item['policy_manual_id'] && $cart_item['policy_manual']->document) {
						if ($applied_coupon && $applied_coupon->type == 'percentage' && $applied_coupon->value == 100) {
							$cart_amount = cart_total_calculation();
							if ($cart_amount && $cart_amount['total'] == 0) {
								$download_url = asset('policy-manual/' . $cart_item['policy_manual']->document);
							}
						}
					}
				}

				Session::put('cart_data', $cartData);
				// Session::save();
			}

			return view('front.cart', compact('cartData', 'session_cart_help', 'download_url'));
		}

		return back()->with('error', 'You\'re unauthorized to perform this action!');
	}

	/**
	 * @param Request $request
	 * @param $course_id
	 */
	public function add(Request $request, $course_id)
	{
		$allow = TRUE;
		$modelShow = TRUE;
		$user_id = NULL;
		$course = Course::find($course_id);
		$is_subscription_course = in_array(1, $course->categories->pluck('id')->toArray());

		if (Auth::check()) {
			$user = User::find(Auth::id());
			$allow = FALSE;
			if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
				$user_id = $user->id;
				$allow = TRUE;
			}
		}

		if ($allow == TRUE) {
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];

			if ($is_subscription_course == TRUE) {
				$session_cart_data = [];
			} else {
				if (!empty($session_cart_data)) {
					$key = array_search(TRUE, array_column($session_cart_data, 'is_subscription_course'));
					if ($key !== FALSE) {
						return response()->json(['status' => false, 'message' => "You can't add the course, as you have already added the subscription course."]);
					}
				}
			}

			if ($session_cart_data && count($session_cart_data)) {
				foreach ($session_cart_data as $session_data) {
					if (isset($session_data['course_id']) && $session_data['course_id'] == $course_id) {
						return response()->json(['status' => false, 'message' => "You already added this course."]);
					}
				}
			}

			$session_cart_data[] = [
				'user_id' => $user_id,
				'ip' => $request->ip(),
				'course_id' => $course_id,
				'course' => $course,
				'quantity'  => 1,
				'is_subscription_course' => $is_subscription_course
			];

			if ($request->help && count($request->help)) {
				Session::put('cart_help', $request->help);
			} else {
				if (Session::has('cart_help')) {
					Session::forget('cart_help');
				}
			}

			Session::put('cart_data', array_values($session_cart_data));
			Session::save();

			/* Start: Abandoned Cart */
			abandonedCart($course_id, null, 1);
			/* End: Abandoned Cart */

			$cart_courses_ids = array_column($session_cart_data, 'course_id');
			$cart_policies_ids = array_column($session_cart_data, 'policy_manual_id');
			$fbt_courses = Course::where('is_in_fbt', 1)->whereNotIn('id', $cart_courses_ids)->get();
			$fbt_policy_ids = $course->policy_manuals->isEmpty() ? [] : $course->policy_manuals->pluck('id');

			$fbt_policies = collect([]);
			
			if (!empty($fbt_policy_ids)) {
				$fbt_policies = PolicyManual::where('is_in_fbt', 1)->whereNotIn('id', $cart_policies_ids)->whereIn('id', $fbt_policy_ids)->get();
			}

			if ($fbt_courses->isEmpty() && $fbt_policies->isEmpty()) {
				$modelShow = FALSE;
			}

			$view = view('front.fbt_items', compact('course', 'fbt_courses', 'fbt_policies'))->render();

			return response()->json(['status' => true, 'message' => 'Item added to cart.', 'data' => $view, 'cart_count' => count($session_cart_data), 'modelShow' => $modelShow]);
		}
		return response()->json(['status' => false, 'message' => 'You\'re unauthorized to perform this action!']);
	}

	/**
	 * @param Request $request
	 * @param $policy_id
	 */
	public function add_policy(Request $request, $policy_id)
	{
		$policy = PolicyManual::find($policy_id);

		$modelShow = TRUE;
		$allow = TRUE;
		if (Auth::check()) {
			$allow = FALSE;
			$user = User::find(Auth::id());
			if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
				$allow = TRUE;
			}
		}

		if ($allow == TRUE) {
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];

			if (!empty($session_cart_data)) {
				$key = array_search(TRUE, array_column($session_cart_data, 'is_subscription_course'));
				if ($key !== FALSE) {
					return response()->json(['status' => false, 'message' => "You can't add the policy, as you have added the subscription item."]);
				}
			}

			if ($session_cart_data && count($session_cart_data)) {
				foreach ($session_cart_data as $session_data) {
					if (isset($session_data['policy_manual_id']) && $session_data['policy_manual_id'] == $policy_id) {
						return response()->json(['status' => false, 'message' => "You already added this policy."]);
					}
				}
			}

			$session_cart_data[] = [
				'user_id' => Auth::check() ? Auth::user()->id : null,
				'ip' => $request->ip(),
				'policy_manual_id' => $policy_id,
				'policy_manual' => $policy,
				'quantity' => 1
			];

			/* Start: Abandoned Cart */
			abandonedCart(null, $policy_id, 1);
			/* End: Abandoned Cart */

			if ($request->help && count($request->help)) {
				Session::put('cart_help', $request->help);
			} else {
				if (Session::has('cart_help')) {
					Session::forget('cart_help');
				}
			}

			Session::put('cart_data', $session_cart_data);
			Session::save();

			$cart_courses_ids = array_column($session_cart_data, 'course_id');
			$cart_policies_ids = array_column($session_cart_data, 'policy_manual_id');
			$fbt_courses = Course::where('is_in_fbt', 1)->whereNotIn('id', $cart_courses_ids)->get();
			$fbt_policies = PolicyManual::where('is_in_fbt', 1)->whereNotIn('id', $cart_policies_ids)->get();

			if ($fbt_courses->isEmpty() && $fbt_policies->isEmpty()) {
				$modelShow = FALSE;
			}

			$view = view('front.fbt_items', compact('policy', 'fbt_courses', 'fbt_policies'))->render();
			return response()->json(['status' => true, 'message' => 'Item added to cart.', 'data' => $view, 'cart_count' => count($session_cart_data), 'modelShow' => $modelShow]);
		}
		return response()->json(['status' => false, 'message' => 'You\'re unauthorized to perform this action!']);
	}

	/**
	 * @param $id
	 */
	public function remove($id)
	{
		$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];

		/* Start: Abandoned Cart */
		if (isset($session_cart_data[$id])) {
			$course_id = $session_cart_data[$id]['course_id'] ?? null;
			$policy_manual_id = $session_cart_data[$id]['policy_manual_id'] ?? null;

			if ($course_id) {
				abandonedCart($course_id, null, 2);
			}
			if ($policy_manual_id) {
				abandonedCart(null, $policy_manual_id, 2);
			}
		}
		/* End: Abandoned Cart */

		unset($session_cart_data[$id]);
		Session::put('cart_data', array_values($session_cart_data));
		Session::save();
		return back()->with('success', 'Item removed from cart.');
	}

	/**
	 * @param Request $request
	 * @param $id
	 */
	public function quantity(Request $request, $id)
	{
		$coupon_code = Session::has('applied_coupon') ? Session::get('applied_coupon')->code : NULL;
		$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];

		foreach ($request->course as $index => $course_names) {
			$certificate_details['names'] = array_values($course_names);
			$certificate_details['coupon_code'] = $coupon_code;
			$session_cart_data[$index]['certificate_details'] = json_encode($certificate_details);
			$session_cart_data[$index]['quantity'] = count($course_names);
		}

		if ($request->help && count($request->help)) {
			Session::put('cart_help', $request->help);
		} else {
			if (Session::has('cart_help')) {
				Session::forget('cart_help');
			}
		}

		Session::put('cart_data', $session_cart_data);
		Session::save();

		return response()->json(['success' => true]);
	}

	/**
	 * @param Request $request
	 */
	public function apply_coupon(Request $request)
	{
		if ($request->ajax()) {
			$coupon_code = $request->coupon_code;
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];

			if ($request->course) {
				foreach ($request->course as $id => $course_names) {
					$certificate_details['names'] = array_values($course_names);
					$session_cart_data[$id]['certificate_details'] = json_encode($certificate_details);
					$session_cart_data[$id]['quantity'] = count($course_names);
				}

				Session::put('cart_data', $session_cart_data);
			}

			$message = 'Invalid coupon code';
			$success = false;
			$coupon = Coupon::where('code', $coupon_code)->first();
			if ($coupon) {
				if ($coupon->expired_at && (strtotime($coupon->expired_at) < strtotime(date('Y-m-d')))) {
					return response()->json(['success' => false, 'message' => 'The coupon code is expired']);
				}

				$success = true;
				$message = $coupon->code . ' is applied.';
				Session::put('applied_coupon', $coupon);
			}

			if ($request->help && count($request->help)) {
				Session::put('cart_help', $request->help);
			} else {
				if (Session::has('cart_help')) {
					Session::forget('cart_help');
				}
			}

			Session::save();
			return response()->json(['success' => $success, 'message' => $message]);
		}

		return response()->json(['success' => false, 'message' => 'Invalid request.']);
	}

	/**
	 * @param Request $request
	 */
	public function remove_coupon(Request $request)
	{
		if ($request->ajax()) {
			Session::forget('applied_coupon');
			Session::save();

			return response()->json(['success' => true, 'message' => 'Coupon removed successfully.']);
		}

		return response()->json(['success' => false, 'message' => 'Invalid request.']);
	}

	/**
	 * @param CartRequest $request
	 */
	public function update_cart(CartRequest $request)
	{
		$coupon_code = Session::has('applied_coupon') ? Session::get('applied_coupon')->code : NULL;

		if ($request->course) {
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
			foreach ($request->course as $id => $course_names) {
				$certificate_details['names'] = array_values($course_names);
				$certificate_details['coupon_code'] = $coupon_code;
				$session_cart_data[$id]['certificate_details'] = json_encode($certificate_details);
				$session_cart_data[$id]['quantity'] = count($course_names);
			}

			if ($request->help && count($request->help)) {
				Session::put('cart_help', $request->help);
			} else {
				if (Session::has('cart_help')) {
					Session::forget('cart_help');
				}
			}

			Session::put('cart_data', $session_cart_data);
			Session::save();
		}

		return redirect(route('checkout'));
	}

	/**
	 * @param Request $request
	 */
	public function checkout(Request $request)
	{
		$stripe_key = get_setting_value('stripe_key');
		$stripe_key = $stripe_key ? $stripe_key : env('STRIPE_SECRET');
		\Stripe\Stripe::setApiKey($stripe_key);

		if (Auth::check()) {
			$user = User::find(Auth::id());
			$customer_id = $user->stripe_id;
			$applied_coupon = session()->has('applied_coupon') ? session()->get('applied_coupon') : null;
			$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];

			// check user if not a caregiver
			if ($user->hasRole(Config::get('constants.users_roles.caregiver'))) {
				return redirect()->back()->with('error', 'Caregivers cannot purchase course, please contact admin for change role.');
			}

			if ($applied_coupon) {
				if ($applied_coupon->id === 1) {
					$coupon_applied_earlier = StripeResponse::where('user_id', $user->id)->where('coupon_id', 1)->where('payment_status', 'paid')->first();

					if ($coupon_applied_earlier) {
						return redirect()->route('cart')->with('error', 'You have already claimed the ' . $applied_coupon->code . ' coupon.');
					}
				}
			}

			if ($user->stripe_id == NULL) {
				try {
					$striprCustomer = [
						'name' => $user->first_name . ' ' . $user->last_name
					];
					if ($user->email) {
						$striprCustomer['email'] = $user->email;
					}
					$stripe_customer = \Stripe\Customer::create($striprCustomer);

					User::where('id', $user->id)->update([
						'stripe_id' => $stripe_customer->id
					]);
					$customer_id = $stripe_customer->id;
				} catch (Exception $e) {
					return redirect()->back()->with('error', $e->getMessage());
				}
			}

			$cart_amount = cart_total_calculation();
			$sub_total = $cart_amount['sub_total'];
			$total = $cart_amount['total'];
			$discount = $cart_amount['discount'];
			$total_tax = $cart_amount['tax'];
			$subscription = false;
			$qty = 0;

			$cart_items = [];
			if (!empty($session_cart_data)) {
				$any_errors = FALSE;
				$error_data = array();

                foreach ($session_cart_data as $cart_item) {
                    if (isset($cart_item['course'])) {
                        if (!isset($cart_item['certificate_details'])) {
                            return redirect()->route('cart')->with('error', 'Please add certificate names.');
                        }
                    }
                }

				foreach ($session_cart_data as $key_cart_item => $cart_item) {
					if (isset($cart_item['course'])) {
						$cart_items['courses'][] = $cart_item['course_id'];
						$cart_course = $cart_item['course'];
						$course_categories = $cart_course->categories->pluck('id')->toArray();
						$qty += $cart_item['quantity'];

						// Check course has subscription or not
						if (isset($cart_item['course_id'])) {
							$courseSubscription = Course::where('id', $cart_item['course_id'])->whereHas('categories', function ($query) {
								$query->where('category_id', 1);
							})->first();
							if ($courseSubscription) {
								$subscription = $courseSubscription;
							}
							/* Start: Abandoned Cart */
							abandonedCart($cart_item['course_id'], null, 3);
							/* End: Abandoned Cart */
						}

						// Check if user already have subscription
						$userSubscription = UserSubscription::where('user_id', Auth::user()->id)->first();
						if ($userSubscription) {
							return redirect()->route('cart')->with('error', 'You already have a subscription. no need to purchase any course or subscription.');
						}

						if (!in_array(1, $course_categories)) {
							$names = isset($cart_item['certificate_details']) ? json_decode($cart_item['certificate_details'], true)['names'] : NULL;
							if ($names) {
								for ($i = 0; $i < $cart_item['quantity']; $i++) {
									$caregiver = User::where('email', $names[$i]['email'])->first();
									if ($names[$i]['email'] && $caregiver) {
										if (Auth::user()->id != $caregiver->id) {
											if ($caregiver->parent_id != $user->id) {
												$any_errors = TRUE;
												$error_data['course.' . $key_cart_item . '.' . $i . '.email'] = ["This $caregiver->email user belongs to another customer, please use different email"];
											}
										}

										// Check already assigned course and it is in progress
										$userCourseExist = UserCourse::where('caregiver_id', $caregiver->id)->where('course_id', (int)$cart_item['course_id'])->where('is_completed', 0)->first();

										if ($userCourseExist) {
											$any_errors = TRUE;
											$error_data['course.' . $key_cart_item . '.' . $i . '.email'] = ["This course is already assigned and in progress for this user."];
										}
									}
								}
							}
						}
					} elseif (isset($cart_item['policy_manual'])) {
						$cart_items['policies'][] = $cart_item['policy_manual_id'];
						$qty += $cart_item['quantity'];

						// Check policy is already purchased
						$userPolicyExist = UserPolicy::where('user_id', $user->id)->where('policy_manual_id', (int)$cart_item['policy_manual_id'])->first();

						/* Start: Abandoned Cart */
						abandonedCart(null, $cart_item['policy_manual_id'], 3);
						/* End: Abandoned Cart */

						if ($userPolicyExist) {
							$any_errors = TRUE;
							$error_data['policy.' . $key_cart_item] = ["This policy is already purchased."];
						}
					}
				}

				if ($any_errors == TRUE) {
					return redirect()->route('cart')->withErrors($error_data);
				}

				if ($subscription) {
					$stripe_enviroment = get_setting_value('stripe_enviroment');
					if ($stripe_enviroment == 'test') {
						$price_id = $subscription->test_plan_id;
					} else {
						$price_id = $subscription->live_plan_id;
					}
					$checkout_session = \Stripe\Checkout\Session::create([
						'customer' => $customer_id,
						'line_items' => [
							[
								'price' => $price_id,
								'quantity' => 1
							],
						],
						'mode' => 'subscription',
						'success_url' => route('checkout.success', [], true) . '?checkout_session_id={CHECKOUT_SESSION_ID}',
						'cancel_url' => route('checkout.cancel', [], true) . '?checkout_session_id={CHECKOUT_SESSION_ID}',
					]);
				} else {
					$checkout_session = \Stripe\Checkout\Session::create([
						'customer' => $customer_id,
						'line_items' => [
							[
								'price_data' => [
									'currency' => 'usd',
									'product_data' => [
										'name' => 'Courses'
									],
									'unit_amount' => $total * 100
								],
								'quantity' => 1
							]
						],
						'mode' => 'payment',
						'invoice_creation' => ['enabled' => true],
						'success_url' => route('checkout.success', [], true) . '?checkout_session_id={CHECKOUT_SESSION_ID}',
						'cancel_url' => route('checkout.cancel', [], true) . '?checkout_session_id={CHECKOUT_SESSION_ID}',
					]);
				}

				StripeResponse::create([
					'user_id' => $user->id,
					'cart_items' => json_encode($cart_items),
					'coupon_id' => !empty($applied_coupon) ? $applied_coupon->id : NULL,
					'order_id' => generateUniqueOrderId(),
					'qty' => $qty,
					'sub_total' => $sub_total,
					'tax' => $total_tax,
					'discount' => $discount,
					'total_amount' => $total,
					'type' => 'checkout_session',
					'session_data' => json_encode($session_cart_data),
					'response_id' => $checkout_session->id,
					'stripe_response' => json_encode($checkout_session),
					'payment_status' => $checkout_session->payment_status,
					'status' => $checkout_session->status
				]);

				return redirect($checkout_session->url);
			}
		}

		return redirect(route('front.home'))->with('error', 'Something went wrong!');
	}

	/**
	 * @param Request $request
	 */
	public function checkout_success(Request $request)
	{
		$checkout_session_id = $request->get('checkout_session_id');
		$stripe_key = get_setting_value('stripe_key');
		$stripe_key = $stripe_key ? $stripe_key : env('STRIPE_SECRET');
		\Stripe\Stripe::setApiKey($stripe_key);
		$user = Auth::user();

		DB::beginTransaction();
		try {
			$checkout_session = \Stripe\Checkout\Session::retrieve($checkout_session_id);
			if ($checkout_session->payment_status == 'paid') {
				$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
				$session_cart_help = Session::has('cart_help') ? Session::get('cart_help') : [];
				if (!empty($session_cart_data)) {
					$stripe_response = StripeResponse::where('response_id', $checkout_session_id)->first();
					$applied_coupon = session()->has('applied_coupon') ? session()->get('applied_coupon') : null;

					if ($session_cart_help && count($session_cart_help)) {
						CartHelp::updateOrCreate([
							'order_id' => $stripe_response->id
						], [
							'user_id' => $user->id,
							'help' => implode(', ', $session_cart_help)
						]);
					}

					foreach ($session_cart_data as $cart_item) {
						if (isset($cart_item['course'])) {
							$cart_course = $cart_item['course'];
							$course_categories = $cart_course->categories->pluck('id')->toArray();

							/* Start: Abandoned Cart */
							abandonedCart($cart_item['course_id'], null, 4);
							/* End: Abandoned Cart */

							if (in_array(1, $course_categories)) {
								UserSubscription::updateOrCreate([
									'user_id' => $user->id,
									'order_id' => $stripe_response->id,
									'course_id' => $cart_item['course_id'],
								], [
									'purchase_date' => Carbon::now(),
								]);
							} else {
								$names = isset($cart_item['certificate_details']) ? json_decode($cart_item['certificate_details'], true)['names'] : NULL;
								if ($names) {
									for ($i = 0; $i < $cart_item['quantity']; $i++) {
										//Generate Random password.
										$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
										$password = substr(str_shuffle($chars), 0, 10);

										$caregiver = '';
                                        if ($names[$i]['email']) {
                                            $caregiver = User::where('email', $names[$i]['email'])->first();
                                        }
                                        if (!$caregiver) {
											$caregiver = User::create([
												'agency_name' => '',
												'parent_id' => $user->id,
												'first_name' => $names[$i]['first_name'] ?? $user->first_name,
                                                'last_name' => $names[$i]['last_name'] ?? $user->last_name,
												'email' => $names[$i]['email'] ?? null,
												'phone' => '',
												'username' => '',
												'is_password_sent' => 1,
												'password' => Hash::make($password)
											]);

											VerifyUser::create([
												'user_id' => $caregiver->id,
												'token' => sha1(time())
											]);

											$role = Role::updateOrCreate(['name' => Config::get('constants.users_roles.caregiver')]);
											$caregiver->assignRole($role);
											if ($names[$i]['email']) {
												$this->sendAccountDetailsEmail($names[$i]['email'], $caregiver, $password);
											}
										}

										UserCourse::updateOrCreate([
											'user_id' => $user->id,
											'order_id' => $stripe_response->id,
											'course_id' => $cart_item['course_id'],
											'caregiver_id' => $caregiver->id,
										], [
											'certificate_name' => ($names[$i]['first_name'] ?? $caregiver->first_name) . ' ' . ($names[$i]['last_name'] ?? $caregiver->last_name),
											'purchase_date' => Carbon::now(),
										]);
									}
								}
							}
						} elseif (isset($cart_item['policy_manual'])) {
							UserPolicy::updateOrCreate([
								'user_id' => $user->id,
								'order_id' => $stripe_response->id,
								'policy_manual_id' => $cart_item['policy_manual_id'],
							], [
								'purchase_date' => Carbon::now(),
							]);

							/* Start: Abandoned Cart */
							abandonedCart(null, $cart_item['policy_manual_id'], 4);
							/* End: Abandoned Cart */
						}
					}

					$receipt = createInvoicePdf($user, $stripe_response);

					$stripe_response->update([
						'invoice' => $receipt,
						'stripe_response' => json_encode($checkout_session),
						'payment_status' => $checkout_session->payment_status,
						'status' => $checkout_session->status
					]);

					$mail_data = [
						'name' => $user->first_name . ' ' . $user->last_name,
						'email' => $user->email,
						'invoice_pdf' => $receipt ? public_path('/pdfs/order_invoices/' . $receipt) : '',
						'order_id' => $stripe_response->order_id,
						'amount' => '$' . $stripe_response->total_amount,
						'stripe_response' => json_decode($stripe_response->session_data),
						'sub_total' => $stripe_response->sub_total,
						'tax' => $stripe_response->tax,
						'discount' => $stripe_response->discount,
						'total_amount' => $stripe_response->total_amount
					];

					if ($user->email) {
						try {
							Mail::to($user->email)->send(new InvoiceMail($mail_data));
						} catch (Exception $e) {
							Log::info($e->getMessage());
						}
					}

					if (!empty($applied_coupon)) {
						Session::forget('applied_coupon');
					}

					Session::forget('cart_data');
					if (Session::has('cart_help')) {
						Session::forget('cart_help');
					}
					Session::save();
					DB::commit();

					return redirect(route('thank-you') . '?order=' . str_replace("#", "", $stripe_response->order_id))->with('success', 'Payment made successfully.');
				}
			}
		} catch (\Exception $e) {
			DB::rollback();
			Log::info($e->getMessage());

			return redirect()->route('front.home')->with('error', 'Something went wrong!');
		}
		DB::rollback();

		return redirect()->route('front.home')->with('error', 'Something went wrong!');
	}

	/**
	 * @param Request $request
	 */
	public function checkout_cancel(Request $request)
	{
		$checkout_session_id = $request->get('checkout_session_id');
		$user = Auth::user();
		StripeResponse::where('user_id', $user->id)->where('response_id', $checkout_session_id)->delete();

		return redirect()->route('front.home')->with('error', 'Payment cancelled!');
	}

	/**
	 * @param $payment_intent_id
	 * @param $order_id
	 * @return mixed
	 */
	public function generateStripeInvoice($payment_intent_id, $order_id)
	{
		$stripe_key = get_setting_value('stripe_key');
		$stripe_key = $stripe_key ? $stripe_key : env('STRIPE_SECRET');

		try {
			\Stripe\Stripe::setApiKey($stripe_key);

			$payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

			$charge = [];
			if (isset($payment_intent->charges)) {
				$charge = $payment_intent->charges->data[0];
			} elseif (isset($payment_intent->latest_charge)) {
				$charge = \Stripe\Charge::retrieve($payment_intent->latest_charge);
			}

			if (!empty($charge)) {
				$contents = file_get_contents($charge->receipt_url);
				$contents = str_replace('<img alt="" height="156" width="252" src="https://stripe-images.s3.amazonaws.com/notifications/hosted/20180110/Header/Left.png" style="display: block;border: 0;line-height: 100%;width: 100%;">', '', $contents);
				$contents = str_replace('<img alt="" height="156" width="252" src="https://stripe-images.s3.amazonaws.com/notifications/hosted/20180110/Header/Right.png" style="display: block;border: 0;line-height: 100%;width: 100%;">', '', $contents);
				$contents = str_replace('<img alt="" height="156" width="96" src="https://stripe-images.s3.amazonaws.com/notifications/hosted/20180110/Header/Icon--empty.png" style="display: block;border: 0;line-height: 100%;">', '', $contents);
				$contents = str_replace('background-color: #525F7F;', '', $contents);
				$contents = str_replace('height="156"', '', $contents);
				$contents = str_replace('background-color:#f6f9fc;', 'background-color:#ffffff;', $contents);
				$contents = str_replace('class="st-Background" bgcolor="#f6f9fc"', 'class="st-Background" bgcolor="#ffffff"', $contents);
				$contents = str_replace('class="st-Email" bgcolor="#f6f9fc"', 'class="st-Email" bgcolor="#ffffff"', $contents);
				$contents = str_replace('receiving this email because', 'receiving this because', $contents);

				$pdf_file_name = str_replace('#', '', $order_id) . '-' . time() . '.pdf';

				$pdf_destination_path = public_path('/pdfs/order_invoices/');

				if (!file_exists($pdf_destination_path)) {
					mkdir($pdf_destination_path, 0777, true);
				}

				$pdf = PDF::loadHTML($contents)->setPaper('a4', 'portrait');
				$pdf->save($pdf_destination_path . $pdf_file_name);

				return $pdf_file_name;
			}
		} catch (\Exception $e) {
			Log::info($e->getMessage());

			return redirect()->route('front.home')->with('error', 'Something went wrong!');
		}

		return redirect()->route('front.home')->with('error', 'Something went wrong!');
	}
}
