<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\AddPhoneRequest;
use App\Http\Requests\AssignCourseRequest;
use Carbon\Carbon;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Traits\SendEmail;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use App\Traits\MondayComTrait;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\FrontProfileRequest;
use App\Http\Requests\ResetPaaswordRequest;
use App\Http\Requests\ChangePaaswordRequest;
use App\Models\Course;
use App\Models\Review;
use App\Models\StripeResponse;
use App\Models\UserCourse;
use App\Models\UserPolicy;

class UserController extends Controller
{
	use SendEmail, MondayComTrait;
	public function __construct()
	{
		View::share('module', 'user');
	}

	public function userCourses(Request $request)
    {
        if ($request->ajax()) {
            $userCourse = UserCourse::select(
                    'user_courses.*',
                    DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_name"),
                    'courses.title as course_title'
                )
                ->join('users', 'users.id', '=', 'user_courses.user_id')
                ->join('courses', 'courses.id', '=', 'user_courses.course_id');

            if (!$request->order) {
                $userCourse->orderBy('user_courses.created_at', 'desc');
            }

            return Datatables::of($userCourse)
                ->addIndexColumn()
                ->editColumn('purchase_date', function ($row) {
                    return optional($row->purchase_date)->format('m/d/Y');
                })
                ->addColumn('user', function ($row) {
                    return $row->user_name;
                })
                ->addColumn('course', function ($row) {
                    return $row->course_title;
                })
                ->addColumn('is_completed', function ($row) {
                    return $row->is_completed
                        ? '<span class="badge badge-success">Completed</span>'
                        : '<span class="badge badge-danger">Not Completed</span>';
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="dropdown-item delete" href="javascript:void(0)" data-url="' . route('user-courses.destroy', $row->id) . '">Delete</a>';
                    return '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                                <div class="dropdown-menu">' . $actions . '</div>
                            </div>';
                })
                ->rawColumns(['is_completed', 'action'])
                ->make(true);
        }
        return view('admin.user.user-courses');
    }

	public function ajax(Request $request)
	{
		$query = User::select(['*', DB::raw("CONCAT(users.first_name,' ',users.last_name) as name")]);
		$roles[] = Config::get('constants.users_roles.customer');
		$data = $query->with(['roles'])->whereHas('roles', function ($query) use ($roles) {
			return $query->whereIn('name', $roles);
		})->latest();
		return Datatables::of($data)
			->addIndexColumn()
			->addColumn('name', function ($row) {
				$name = '<p class="m-0 mb-1">' . $row->first_name . ' ' . $row->last_name . '</p>';
				if ($row->last_login) {
					$test = strtotime($row->last_login);
					$row->last_login  = (!$test || $test < 0) ? '0000-00-00 00:00:00' : $row->last_login;
					$name .= '<span>Last login: ' . $row->last_login->format('m/d/Y H:i') . '</span>';
				} else {
					$name .= '<span>Last login: Never</span>';
				}
				return $name;
			})
			->addColumn('status', function ($row) {
				$checked = $row->status ? 'checked' : NULL;
				$html = '<div class="custom-control custom-checkbox">';
				$html .= '<input type="checkbox" class="custom-control-input activeInactive" id="active_inactive_user_' . $row->id . '" target-url="' . route('user.status', ['user' => $row->id]) . '" ' . $checked . '>';
				$html .= '<label class="custom-control-label" for="active_inactive_user_' . $row->id . '"></label>';
				$html .= '</div>';

				return $html;
			})
			->addColumn('registered_at', function ($row) {
				return Carbon::parse($row->created_at)->format('m/d/Y');
			})
			->addColumn('action', function ($row) {
				$actions = '<a class="dropdown-item" href="' . route('user.login', $row->id) . '">Switch to</a>';
				$actions .= '<a class="dropdown-item edit" href="' . route('user.edit', ['user' => $row->id]) . '">Edit</a>';
				$actions .= '<a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row->id . '" target-url="' . route('user.destroy', ['user' => $row->id]) . '">Delete</a>';
				$actions .= '<a class="dropdown-item reset_password" href="javascript:void(0)" data-id="' . $row->id . '">Reset Password</a>';
				$actions .= '<a class="dropdown-item caregiver" href="javascript:void(0)" data-id="' . $row->id . '" >Show Caregivers</a>';

				$btn = '<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Action
					</button>';
				$btn .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
				$btn .= $actions;
				$btn .= '</div></div>';
				return $btn;
			})
			->rawColumns(['name', 'status', 'registered_at', 'action'])
			->filterColumn('name', function ($query, $keyword) {
				$query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$keyword}%"]);
			})
			->make(true);
	}

	public function caregiver_ajax(Request $request, $id)
	{
		$caregiver = User::where('parent_id', $id)->latest()->get();
		return Datatables::of($caregiver)
			->addIndexColumn()
			->addColumn('action', function ($row) {
				$actions = '<a class="dropdown-item" href="' . route('user.login', $row->id) . '">Switch to</a>';
				$actions .= '<a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row->id . '" target-url="' . route('user.destroy', ['user' => $row->id]) . '">Delete</a>';

				$btn = '<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Action
						</button>';
				$btn .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
				$btn .= $actions;
				$btn .= '</div></div>';
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
		return view('admin.user.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$countries = Country::all();
		return view('admin.user.create', compact('countries'));
	}

	public function assigncourse($id)
	{
		$course = Course::find($id);
		$data = view('admin.user.course', compact('course'))->render();
		return response()->json(['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		//Generate Random password. 
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$password = substr(str_shuffle($chars), 0, 10);

		$insert_data = $request->except('_token');
		$insert_data['password'] = Hash::make($password);

		$user = User::create($insert_data);

		// Create Stripe Customer
		$user->createAsStripeCustomer([
			'name' => $request->first_name . ' ' . $request->last_name,
			'email' => $request->email
		]);

		$role = Role::updateOrCreate(['name' => Config::get('constants.users_roles.customer')]);
		$user->assignRole($role);

		VerifyUser::create([
			'user_id' => $user->id,
			'token' => sha1(time())
		]);

		// Add Data in Monday API
		$this->add($user);

		// Send Email
		$this->sendAccountDetailsEmail($user->email, $user, $password);

		return redirect()->route('user.index')->with(['success' => 'User added successfully.']);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function profile($id)
	{
		$userprofile = User::find($id);
		$current_plan = [];
		$cards = [];
		$default_card = [];
		$countries = Country::all();
		$states = State::all();
		return view('admin.user.profile', compact('userprofile', 'current_plan', 'cards', 'default_card', 'countries', 'states'));
	}

	public function updateProfile(ProfileRequest $request)
	{
		$input = [
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'phone' => $request->phone,
			'address' => $request->address,
			'city' => $request->city,
			'zipcode' => $request->zipcode,
			'country_id' => $request->country_id,
			'state' => $request->state,
			'username' => $request->username,
			'license_type' => $request->license_type && count($request->license_type) ? implode(', ', $request->license_type) : null,
		];
		User::where('id', $request->id)->update($input);

		return redirect()->back()->with('success', 'Profile updated successfully.');
	}

	public function changePassword(ChangePaaswordRequest $request)
	{
		if (Hash::check($request->current_password, auth()->user()->password)) {
			User::find(auth()->user()->id)->update([
				'password' => Hash::make($request->password),
				'is_password_sent' => 1
			]);
			return redirect()->back()->with('success', 'Password changed successfully.');
		} else {
			return redirect()->back()->with('error', "Current password didn't matched.");
		}
	}

	public function resetPassword(ResetPaaswordRequest $request)
	{
		if ($request->password) {
			User::find($request->user_id)->update([
				'is_password_sent' => 1,
				'password' => Hash::make($request->password)
			]);
			return redirect()->back()->with('success', 'Password changed successfully.');
		} else {
			return redirect()->back();
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		$data  = $user;
		$countries = Country::all();
		$states = State::where('country_id', $user->country_id)->orderBy('name', 'ASC')->get();
		$courses = Course::orderBy('order')->get();
		return view('admin.user.create', compact('data', 'countries', 'states', 'courses'));
	}

	public function show($id)
	{
		$user = User::findOrfail($id);
		return view('admin.user.show', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserRequest $request, User $user)
	{
		$update_data = $request->except('_token', '_method');
		$update_data['license_type'] = $request->license_type && count($request->license_type) ? implode(', ', $request->license_type) : null;
		$user->update($update_data);
		return redirect()->route('user.index')->with(['success' => 'User updated successfully.']);
	}

	public function status(User $user)
	{
		$user->status = $user->status ? NULL : 1;
		if (!$user->email_verified_at) {
			$user->email_verified_at = now();
		}
		$user->save();
		Session::flash('User status updated successfully.');
		return redirect()->route('user.index')->with(['success' => 'User status updated successfully.']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		if ($user->parent_id) {
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			UserCourse::where('caregiver_id', $user->id)->delete();
			$user->delete();
			Session::put('success', 'User deleted successfully.');
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
			return response()->json(['status' => true]);
		} else {
			DB::beginTransaction();
			try {

				DB::statement('SET FOREIGN_KEY_CHECKS=0');
				User::where('parent_id', $user->id)->delete();
				UserCourse::where('user_id', $user->id)->delete();
				UserPolicy::where('user_id', $user->id)->delete();
				Review::where('user_id', $user->id)->delete();
				StripeResponse::where('user_id', $user->id)->delete();
				$user->delete();
				DB::statement('SET FOREIGN_KEY_CHECKS=1');

				DB::commit();
				Session::put('success', 'User deleted successfully.');
			} catch (\Exception $e) {
				DB::rollBack();
				Session::put('error', $e->getMessage());
			}
			return response()->json(['status' => true]);
		}
	}

	public function userProfile()
	{
		$userprofile = Auth::user();
		$countries = Country::all();
		$states = State::where('country_id', $userprofile->country_id)->orderBy('name', 'ASC')->get();
		return view('front.profile', compact('userprofile', 'countries', 'states'));
	}

	public function userProfileUpdate(FrontProfileRequest $request)
	{
		$input = [
			'agency_name' => $request->agency_name,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'username' => $request->username,
			'email' => $request->email,
			'phone' => $request->phone,
			'address' => $request->address,
			'city' => $request->city,
			'state' => $request->state,
			'country_id' => $request->country_id,
			'zipcode' => $request->zipcode
		];
		User::where('id', $request->id)->update($input);
		return redirect()->back()->with('success', 'Profiles updated successfully.');
	}

	public function listUser()
	{
		return view('admin.user.userList');
	}

	public function userAssignCourse(AssignCourseRequest $request, $user_id)
	{
		DB::beginTransaction();
		try {
			$insert_records = [];
			$names = $request->name;
			$any_errors = FALSE;
			$error_data = array();

			foreach ($names as $key_name => $name) {
				if ($name['email'] && User::where('email', $name['email'])->count()) {
					$caregiver = User::where('email', $name['email'])->first();
					if ($caregiver) {
						if ($caregiver->id != $user_id) {
							if ($caregiver->parent_id != $user_id) {
								$any_errors = TRUE;
								$error_data['name.' . $key_name . '.email'] = ["This $caregiver->email user belongs to another customer, please use different email"];
							}
						}

						// Check already assigned course and it is in progress
						$userCourseExist = UserCourse::where('caregiver_id', $caregiver->id)->where('course_id', $request->course)->where('is_completed', 0)->first();

						if ($userCourseExist) {
							$any_errors = TRUE;
							$error_data['name.' . $key_name . '.email'] = ["This course is already assigned and in progress for this user."];
						}
					}
				}
			}

			if ($any_errors == TRUE) {
				return redirect()->back()->withInput($request->input())->withErrors($error_data);
			}

			foreach ($names as $key_name => $name) {
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$password = substr(str_shuffle($chars), 0, 10);

				$caregiver = "";
				if ($name['email']) {
					$caregiver = User::where('email', $name['email'])->first();
				}
				if (!$caregiver) {
					$caregiver = User::create([
						'agency_name' => '',
						'parent_id' => $user_id,
						'first_name' => $name['first_name'],
						'last_name' => $name['last_name'],
						'email' => $name['email'] ?? null,
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
					if ($name['email']) {
						$this->sendAccountDetailsEmail($name['email'], $caregiver, $password);
					}
				}

				$insert_records[] = [
					'user_id' => $user_id,
					'caregiver_id' => $caregiver->id,
					'course_id' => $request->course,
					'certificate_name' => ($name['first_name'] ?? $caregiver->first_name) . ' ' . ($name['last_name'] ?? $caregiver->last_name),
					'purchase_date' => Carbon::now(),
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				];
			}

			if (count($insert_records)) {
				UserCourse::insert($insert_records);
				DB::commit();
				return back()->with('success', 'Course assigned successfully.');
			}
			return back()->with('error', 'Something went wrong, Please try again.');
		} catch (\Exception $e) {
			DB::rollback();
			return back()->with('error', 'Something went wrong!');
		}
	}

	public function user_old_certificates()
	{
		$files = [];
		$certificatePath = public_path('pdfs/old-certificates/' . strtolower(Auth::user()->email));
		if (file_exists($certificatePath)) {
			$path = opendir($certificatePath); // open directory to read files
			while (false !== ($image = readdir($path))) { // loop through all files
				if ($image != "." && $image != "..") { // remove back entry from list
					$files[] = $image;
				}
			}
			closedir($path);
		}

		return view('admin.user.courses.old_certificates', compact('files'));
	}

	public function user_certificates(Request $request)
	{
		$user = Auth::user();
		$certificates = [];

		if ($request->ajax()) {
			$certificates = UserCourse::with(['course', 'user_course_quiz_answer'])->where('is_completed', 1)->where('certificate', '!=', NULL)->whereHas('course');
			if ($user->hasRole(Config::get('constants.users_roles.caregiver'))) {
				$certificates = $certificates->where('caregiver_id', $user->id);
			} else {
				$certificates = $certificates->where('user_id', $user->id);
			}

			$certificates = $certificates->latest()->get();

			return Datatables::of($certificates)
				->addIndexColumn()
				->addColumn('caregiver', function ($row) {
					return $row->certificate_name ?? ($row->caregiver->first_name . " " . $row->caregiver->last_name);
				})
				->addColumn('passing_score', function ($row) {
					return $row->user_course_quiz_answer->first()->score . "%";
				})
				->addColumn('action', function ($row) {
					$btn = '<div style="display: flex;">';
					$btn .= '<a href="' . asset('/pdfs/certificates/' . $row->certificate) . '" class="btn text-primary certificate-preview" target="_blank">';
					$btn .= '<i class="fa fa-file-pdf"></i>';
					$btn .= '</a>';
					$btn .= '</div>';
					return $btn;
				})
				->rawColumns(['action', 'caregiver'])
				->make(true);
		}

		return view('admin.user.courses.certificates');
	}

	public function usersExport(Request $request)
	{
		$users = new \Illuminate\Database\Eloquent\Collection();
		switch ($request->export_type) {
			case 'inactive_customers_current_year':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->where('status', 0)->whereYear('created_at', Carbon::now()->year)->get();
				break;
			case 'active_customers_current_year':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->where('status', 1)->whereYear('created_at', Carbon::now()->year)->get();
				break;
			case 'new_customers_current_month':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->get();
				break;
			case 'customers_who_did_not_take_any_courses_this_year':
				$user_ids = UserCourse::whereYear('created_at', Carbon::now()->year)->groupBy('user_id')->get()->pluck('user_id')->toArray();
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->whereNotIn('id', $user_ids)->get();
				break;
			case 'all_users':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->get();
				break;
			case 'Home Care':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->where('license_type', 'like', '%Home Care%')->get();
				break;
			case 'Home Health':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->where('license_type', 'like', '%Home Health%')->get();
				break;
			case 'Hospice':
				$users = User::whereHas('roles', function ($query) {
					return $query->where('name', Config::get('constants.users_roles.customer'));
				})->where('license_type', 'like', '%Hospice%')->get();
				break;
			default:
				return response()->json(['status' => false, 'message' => 'Something went wrong!']);
				break;
		}

		if (!$users->isEmpty()) {
			try {
				$excelPath = public_path('/excel');
				if (!file_exists($excelPath)) {
					mkdir($excelPath, 0777, true);
				}
				$file_name = time() . '_users.xlsx';
				$file = \Excel::store(new UsersExport($users), 'excel/' . $file_name, 'real_public');
				return response()->json(['status' => true, 'message' => 'Excel file generated of the users.', 'file_name' => $file_name]);
			} catch (\Exception $e) {
				return response()->json(['status' => false, 'message' => 'Something went wrong!', 'error_message' => $e->getMessage()]);
			}
		}

		return response()->json(['status' => false, 'message' => 'No users found!']);
	}

	public function userAddNumber(AddPhoneRequest $request)
	{
		User::where('id', Auth::id())->update([
			'phone' => $request->phone
		]);

		return back()->with('success', "Phone number updated successfully.");
	}

    public function userCoursesDestroy(UserCourse $userCourse)
    {
        $userCourse->forceDelete();

        return response()->json(['status' => true, 'message' => 'User course deleted successfully.']);
    }
}
