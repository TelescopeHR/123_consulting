<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        View::share('module', 'subscription');
    }

    public function index()
    {
        $userSubscription = UserSubscription::where('user_id', Auth::user()->id)->first();
        if (!$userSubscription) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have any subscription.');
        }
        $courses = Course::whereHas('categories', function($query) {
            $query->where('category_id', '!=', 1);
        })->get();
        return view('admin.subscription.index', compact('courses'));
    }

    public function courseAssign(Course $course)
    {
        $user_id = Auth::user()->id;
        $userSubscription = UserSubscription::where('user_id', Auth::user()->id)->first();
        if (!$userSubscription) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have any subscription.');
        }

        $alreadyAssignedCaregiverIds = UserCourse::where('course_id', $course->id)->where('is_completed', 0)->pluck('caregiver_id')->toArray();
        $caregivers = User::where('parent_id', Auth::user()->id)->whereNotIn('id', $alreadyAssignedCaregiverIds)->latest()->get();
        return view('admin.subscription.assign', compact('course', 'caregivers', 'user_id'));
    }
}
