<?php

use App\Http\Controllers\AbandonedController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CmsPagesController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PolicyManualController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserCertificateController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\UserPolicyController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\IntakeFormController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/* Start: Front routes */

Route::get('register', function () {
	if (Auth::check()) {
		return redirect()->route('front.home')->with('success', 'You already logged in.');
	} else {
		return view('front.register');
	}
})->name('front.register');

Route::get('forgot-password', function () {
	if (Auth::check()) {
		return redirect()->route('front.home')->with('success', 'You already logged in.');
	} else {
		return view('front.forgotPassword');
	}
})->name('front.forgot-password');

Route::get('how-it-works', function () {
	return view('front.howitworks');
})->name('front.how-it-works');

Route::get('/consultation-booking', function () {
    return view('front.consultation-booking');
})->name('front.consultation-booking');

// Route::get('contact-us', function () {
// 	return view('front.contactus');
// })->name('front.contact-us');

Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('cashier.webhook');
Route::post('email-coupon', [HomeController::class, 'email_coupon'])->name('email.coupon');
Route::get('popup-closed', [HomeController::class, 'popupClosed'])->name('popup-closed');

Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('blog', [FrontController::class, 'blog'])->name('front.resources');
Route::get('how-to-videos', [FrontController::class, 'video'])->name('front.video');
Route::get('blog_dev', [FrontController::class, 'blog_dev']);
Route::get('blog/{slug}', [FrontController::class, 'blogDetail'])->name('front.blog.detail');
Route::get('blog-by-category/{id}', [FrontController::class, 'blogByCategory'])->name('blogByCategory');
Route::post('blog-form', [FrontController::class, 'blogForm'])->name('front.blog-form');
Route::post('contact-us', [FrontController::class, 'storeContact'])->name('front.storeContact');
Route::post('register', [FrontController::class, 'register'])->name('front.register.store');
Route::get('user/verify/{token}', [FrontController::class, 'verifyUser']);
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('get-state', [FrontController::class, 'get_state'])->name('get_state');
Route::get('cart/{course_id}/add', [CartController::class, 'add'])->name('cart.add');
Route::get('cart/policy/{policy_manual_id}/add', [CartController::class, 'add_policy'])->name('cart.policy.add');
Route::get('cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/{id}/quantity', [CartController::class, 'quantity'])->name('cart.quantity');
Route::get('edit-profile', [UserController::class, 'userProfile'])->name('user.profile')->middleware('auth');
Route::post('profie-update/{id}', [UserController::class, 'userProfileUpdate'])->name('user.profile.update');
Route::get('my-profile', [FrontController::class, 'myProfile'])->name('front.my-profile')->middleware('auth');
Route::get('courses', [CourseController::class, 'courses'])->name('courses');
Route::post('apply-coupon', [CartController::class, 'apply_coupon'])->name('apply_coupon');
Route::post('remove-coupon', [CartController::class, 'remove_coupon'])->name('remove_coupon');
Route::post('update-cart', [CartController::class, 'update_cart'])->name('cart.update');
Route::get('courses/{slug}', [UserCourseController::class, 'course_details'])->name('courses.details');
Route::get('coursebycategory/{id}', [FrontController::class, 'coursebycategory'])->name('coursebycategory');
Route::get('home/policies', [FrontController::class, 'homePolicies'])->name('home.policies.cards');
Route::get('home/startup-program', [FrontController::class, 'startupProgram'])->name('home.startup.program');
Route::get('home/{slug}', [FrontController::class, 'homeCategory'])->name('home.category');
// Route::get('policy-manual/{policy_manual}', [PolicyManualController::class, 'show'])->name('policy_manual.details');
Route::get('policies-cards', [FrontController::class, 'policiesCards'])->name('policies.cards.ajax');
Route::get('download-policy/{policy_id}', [HomeController::class, 'downloadPolicy'])->name('download.policy');
Route::get('/intake-form', [FrontController::class, 'show'])->name('intake.form');
Route::post('/intake-form', [FrontController::class, 'store'])->name('intake.store');

/* End: Front routes */

/* Start: Common routes */
Route::post('slug/create', [HomeController::class, 'slugCreate'])->name('slug.create');
Route::post('email_exists', [FrontController::class, 'email_exists'])->name('email_exists');
Route::get('course-by-category/search', [HomeController::class, 'courseSearch'])->name('course.search');
Route::get('policy/search', [HomeController::class, 'policySearch'])->name('policy.search');
/* End: Common routes */

/* Start: Admin routes */
Auth::routes([
	'register' => false
]);

Route::get('login-google', [FrontController::class, 'googlewithlogin'])->name('googlewithlogin');
Route::get('callback', [FrontController::class, 'callback'])->name('callback');

Route::group(['middleware' => ['auth']], function () {
	Route::get('user/virtual-login/{id}', [HomeController::class, 'virtualLogin'])->name('user.login');
	Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
	Route::get('profile/{id}', [UserController::class, 'profile'])->name('profile');
	Route::post('user/change-password', [UserController::class, 'changePassword'])->name('user.change-password');
	Route::post('user/update-profile', [UserController::class, 'updateProfile'])->name('user.update-profile');
	Route::post('user-list', [UserController::class, 'listUser'])->name('user.list.page');
	Route::post('user/{user_id}/assign/course', [UserController::class, 'userAssignCourse'])->name('user.assign.course');

	Route::group(['middleware' => 'role:' . Config::get('constants.users_roles.customer') . '|' . Config::get('constants.users_roles.caregiver')], function () {
		// user courses route
		Route::get('in-progress', [UserCourseController::class, 'inProgress'])->name('user.courses.in-progress');
		Route::get('completed', [UserCourseController::class, 'completed'])->name('user.courses.completed');
		Route::get('user-course/{id}', [UserCourseController::class, 'user_course'])->name('user.course');
		Route::get('courses/{course_slug}/lessons/{lesson_slug}', [UserCourseController::class, 'courses_lessons'])->name('user.courses.lessons');
		Route::get('courses/{course_slug}/quizzes/{quiz_slug}', [UserCourseController::class, 'courses_quizzes'])->name('user.courses.quizzes');
		Route::post('store-quiz-answers', [UserCourseController::class, 'store_quiz_answers'])->name('user.course.store-quiz-answers');
		Route::get('course-quiz-result', [UserCourseController::class, 'course_quiz_result'])->name('user.course.course-quiz-result');

		Route::post('user-course-start', [UserCourseController::class, 'userCourseStart'])->name('user.course.start');
		Route::post('user-course-lesson-completed', [UserCourseController::class, 'userCourseLessonCompleted'])->name('user.course.lesson.completed');

		Route::get('feedback/{course}', [UserCourseController::class, 'feedback_form'])->name('user.course.feedback');
		Route::post('submit-feedback', [UserCourseController::class, 'submit_feedback'])->name('user.course.submit-feedback');

		Route::get('user-certificates', [UserController::class, 'user_certificates'])->name('user.certificates');
		Route::get('user-old-certificates', [UserController::class, 'user_old_certificates'])->name('user.old-certificates');
		Route::get('user-policies', [UserPolicyController::class, 'index'])->name('user.policies');

		Route::post('user-add-number', [UserController::class, 'userAddNumber'])->name('user.add-number');
	});

	Route::group(['middleware' => 'role:' . Config::get('constants.users_roles.customer')], function () {
		Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
		Route::get('checkout-success', [CartController::class, 'checkout_success'])->name('checkout.success');
		Route::get('checkout-cancel', [CartController::class, 'checkout_cancel'])->name('checkout.cancel');
		Route::get('thank-you', [FrontController::class, 'thank_you'])->name('thank-you');
		Route::get('subscription/courses', [SubscriptionController::class, 'index'])->name('subscription.index');
		Route::get('subscription/{course}/assign', [SubscriptionController::class, 'courseAssign'])->name('subscription.course.assign');
	});

	Route::group(['middleware' => 'role:' . Config::get('constants.users_roles.super_admin'), 'prefix' => 'admin'], function () {
		/* Start: Datatable routes */
		Route::get('abandoned/ajax', [AbandonedController::class, 'ajax'])->name('abandoned.ajax');
		Route::get('blogs/ajax', [BlogController::class, 'ajax'])->name('blog.ajax');
		Route::get('category/ajax', [CategoryController::class, 'ajax'])->name('category.ajax');
		Route::get('lesson/ajax', [LessonController::class, 'ajax'])->name('lesson.ajax');
		Route::get('quiz/ajax', [QuizController::class, 'ajax'])->name('quiz.ajax');
		Route::get('question/ajax', [QuestionController::class, 'ajax'])->name('question.ajax');
		Route::get('tag/ajax', [TagController::class, 'ajax'])->name('tag.ajax');
		Route::get('media/ajax', [MediaController::class, 'ajax'])->name('media.ajax');
		Route::get('course/ajax', [CourseController::class, 'ajax'])->name('course.ajax');
		Route::get('coupon/ajax', [CouponController::class, 'ajax'])->name('coupon.ajax');
		Route::get('cms-page/ajax', [CmsPagesController::class, 'ajax'])->name('cms-page.ajax');
		Route::get('certificate/ajax', [CertificateController::class, 'ajax'])->name('certificate.ajax');
		Route::get('user/ajax', [UserController::class, 'ajax'])->name('user.ajax');
		Route::get('order/ajax', [OrderController::class, 'ajax'])->name('order.ajax');
		Route::get('caregivers/ajax/{id}', [UserController::class, 'caregiver_ajax'])->name('caregivers.ajax');
		Route::get('policy/ajax', [PolicyManualController::class, 'ajax'])->name('policy.ajax');
		Route::get('/intake-forms/ajax', [IntakeFormController::class, 'ajax'])->name('intakeform.ajax');
		Route::get('/intake-form/{id}', [IntakeFormController::class, 'show'])->name('intakeform.show');
		/* End: Datatable routes */

		Route::get('course/{course}/status', [CourseController::class, 'status'])->name('course.status');

		/* Start: Resource routes */
		Route::resource('abandoneds', AbandonedController::class, ['names' => 'abandoned']);
		Route::resource('blogs', BlogController::class, ['names' => 'blog']);
		Route::resource('categories', CategoryController::class, ['names' => 'category']);
		Route::resource('lessons', LessonController::class, ['names' => 'lesson']);
		Route::resource('quizzes', QuizController::class, ['names' => 'quiz']);
		Route::resource('questions', QuestionController::class, ['names' => 'question']);
		Route::resource('tags', TagController::class, ['names' => 'tag']);
		Route::resource('settings', SettingController::class, ['names' => 'setting']);
		Route::resource('media', MediaController::class, ['names' => 'media']);
		Route::resource('courses', CourseController::class, ['names' => 'course']);
		Route::resource('users', UserController::class, ['names' => 'user']);
		Route::resource('coupons', CouponController::class, ['names' => 'coupon']);
		Route::resource('cms-pages', CmsPagesController::class, ['names' => 'cms-page']);
		Route::resource('certificate', CertificateController::class, ['names' => 'certificate']);
		Route::resource('user-certificate', UserCertificateController::class, ['names' => 'user-certificate']);
        Route::resource('order', OrderController::class, ['names' => 'order']);
		Route::resource('policy', PolicyManualController::class, ['names' => 'policy']);
		Route::resource('videos', VideoController::class, ['names' => 'video']);
		Route::resource('intakeform', IntakeFormController::class, ['names' => 'intakeform']);
		/* End: Resource routes */

        Route::get('user-courses', [UserController::class, 'userCourses'])->name('user-courses.index');
        Route::delete('user-courses/{userCourse}', [UserController::class, 'userCoursesDestroy'])->name('user-courses.destroy');

        Route::put('user-certificates/{id}', [UserCertificateController::class, 'update'])->name('user-certificate.update');

		Route::delete('answer/{answer}', [QuestionController::class, 'answerDestroy'])->name('answer.destroy');

		Route::get('leads', [LeadController::class, 'index'])->name('lead.index');
		Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('lead.destroy');

		Route::get('blog/status/{id}', [BlogController::class, 'status'])->name('blog.status');
		Route::get('blog/premium/{id}', [BlogController::class, 'premium'])->name('blog.premium');

		Route::post('user/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
		Route::get('user/status/{user}', [UserController::class, 'status'])->name('user.status');

		Route::delete('media/delete/{media}', [MediaController::class, 'destroy'])->name('media.delete');
		Route::post('assigncourse/{id}', [UserController::class, 'assigncourse'])->name('assigncourse');
		Route::post('users-export', [UserController::class, 'usersExport'])->name('users.export');

		Route::get('course-reviews/{course}', [CourseController::class, 'reviews'])->name('course.reviews');
		Route::get('review-ratings/{review}', [CourseController::class, 'ratings'])->name('review.ratings');
	});
});
/* End: Admin routes */

Route::get('blog-category/{slug}', [CmsPagesController::class, 'blogByCategory'])->name('blog-by-category');
// dont move this route , always put this route at last
Route::get('{slug}', [CmsPagesController::class, 'page'])->name('front.page');
