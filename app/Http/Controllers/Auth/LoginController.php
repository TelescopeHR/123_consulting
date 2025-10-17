<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Abandoned;
use App\Models\User;
use App\Models\UserToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function showLoginForm()
	{
		return view('front.login');
	}

	public function username()
	{
		$login = request()->input('email');
		$field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		request()->merge([$field => $login]);
		return $field;
	}

	public function login(\Illuminate\Http\Request $request)
	{
		$this->validateLogin($request);

		// This section is the only change
		if ($this->guard()->validate($this->credentials($request))) {
			$user = $this->guard()->getLastAttempted();


			if (!$user->email_verified_at) {
				return redirect()->back()->with('error', 'Your email is not verified, please check your email');
			}

			if (!$user->status) {
				Auth::logout();
				return redirect()->back()->with('error', 'Your account is inactive, please contact administrator');
			}

			if ($user->hasRole([Config::get('constants.users_roles.caregiver')])) {
				$parent_user = User::find($user->parent_id);

				if (Session::has('cart_data')) {
					Session::put('error', "Caregivers cannot purchase course, please contact admin.");
				}

				if (!$parent_user->status) {
					return redirect()->back()->with('error', 'Your agency is inactive, please contact your administrator');
				}
			}

			if ($this->attemptLogin($request)) {
				$user->update([
					'last_login' => date('Y-m-d h:i:s')
				]);

				$this->redirectTo = route('admin.dashboard');
				if ($user->hasRole([Config::get('constants.users_roles.customer')])) {
					$session_cart_data = Session::has('cart_data') ? Session::get('cart_data') : [];
					if (!empty($session_cart_data)) {
						foreach ($session_cart_data as $key_cart_item => $cart_item) {
							$session_cart_data[$key_cart_item]['user_id'] = $user->id;

							/* Start: Abandoned Cart */
							$user_id = $session_cart_data[$key_cart_item]['user_id'];
							if ($user_id) {
								Abandoned::where('ip', $request->ip())->update([
									'user_id' => $user_id
								]);
							}
							/* End: Abandoned Cart */
						}
						Session::put('cart_data', $session_cart_data);
						Session::save();
					}
				}

				if ($user->hasRole([Config::get('constants.users_roles.customer')]) || $user->hasRole([Config::get('constants.users_roles.caregiver')])) {
					$this->redirectTo = route('user.courses.in-progress');

					if (session()->has('url.intended') && (session()->get('url.intended') == route('admin.dashboard'))) {
						session()->put('url.intended', route('user.courses.in-progress'));
					}
				}

				// Send the normal successful login response
				return $this->sendLoginResponse($request);
			}
		}

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$previousUsers = session()->get('previousUsers');
		$user = Auth::user();
		if ($user) {
			UserToken::where('user_id', $user->id)->delete();
		}
		$this->guard()->logout();
		$request->session()->invalidate();
		if (!empty($previousUsers)) {
			$user = array_pop($previousUsers);
			Auth::login($user);
			session()->put('previousUsers', $previousUsers);
		}
		return $this->loggedOut($request) ?: redirect()->route('admin.dashboard');
	}
}
