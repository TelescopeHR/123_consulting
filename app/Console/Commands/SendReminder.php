<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\UserCourse;
use App\Traits\SendEmail;
use Illuminate\Console\Command;

class SendReminder extends Command
{
    use SendEmail;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Send 4 reminder emails
     * 1 month before expired
     * 1 week before expired
     * 1 day before expired
     * On the day of expiry
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
        $courseAdmin8Title = '8 Hour Initial Administrator Training';
        $courseAdmin12Title = '12 Hour CE Administrator Training (Original Version)';
        $courseAdmin16Title = '16 Hour Initial Administrator Training';

        $subject = '';
        $body = '';

        $administrators12 = Course::where('title', $courseAdmin12Title)->first();
        $administrators16 = Course::where('title', $courseAdmin16Title)->first();

        $link4781 = $administrators12 ? route('courses.details', $administrators12->slug_relation->slug) : 'javascript:void(0)';
        $link2566 = $administrators16 ? route('courses.details', $administrators16->slug_relation->slug) : 'javascript:void(0)';

        /* Start: Check for month */
        $month = date('Y', strtotime("-1 year")) . '-' . date('m', strtotime("+1 month")) . '-' . date('d');
        $userCoursesForMonth = UserCourse::whereDate('end_date', $month)->whereHas('caregiver')->whereHas('course', function($queryMonth) use ($courseAdmin8Title, $courseAdmin12Title,$courseAdmin16Title) {
            return $queryMonth->where('title', $courseAdmin8Title)
                ->orWhere('title', $courseAdmin12Title)
                ->orWhere('title', $courseAdmin16Title);
        })->get();

        foreach ($userCoursesForMonth as $userCourseForMonth) {
            $courseName = $userCourseForMonth->course ? $userCourseForMonth->course->title : '';
            $user = $userCourseForMonth->user ? $userCourseForMonth->user : '';
            $completed_date = $userCourseForMonth->end_date->format('m/d/Y');
            $date1 = date('m/d/Y', strtotime('+1 month'));
            $courseNotPurchased = true;

            switch ($courseName) {
                case $courseAdmin12Title:
                    $subject = 'Your 12 Admin Training Hours are Due in One Month';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForMonth->caregiver->first_name . ' ' . $userCourseForMonth->caregiver->last_name) . ' have one month from today, until ' . $date1 . ', to finish your annual 12 Hour Admin Training. Our records show you last completed your 12 Hour Admin Training on ' . $completed_date . ' and must complete them again within one year of that date. You can find the course <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForMonth->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin16Title:
                    $subject = 'Your 12 Admin Training Hours are Due in One Month';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForMonth->caregiver->first_name . ' ' . $userCourseForMonth->caregiver->last_name) . ' have one month from today, until ' . $date1 . ', to finish your 12 Hour Admin Training. Our records show you completed your 16 Hour Admin Training on ' . $completed_date . ' and must complete 12 subsequent hours within one year of that date. The 12 Hour Admin Training can be found <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForMonth->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin8Title:
                    $subject = 'Your 16 Admin Training Hours are Due in One Month';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForMonth->caregiver->first_name . ' ' . $userCourseForMonth->caregiver->last_name) . ' have one month from today, until ' . $date1 . ', to finish your 16 Hour Admin Training. Our records show you completed your 8 Hour Admin Training on ' . $completed_date . ' and must complete 16 subsequent hours within one year of that date. The 16 Hour Admin Training can be found <a href="' . $link2566 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForMonth->caregiver_id)->where('course_id', $administrators16->id)->count()) {
                        $courseNotPurchased = false;
                    }
            }
            if ($courseNotPurchased && $user && $subject && $body) {
                $this->sendReminderEmail($now, $user, $subject, $body);
            }
        }
        /* End: Check for month */

        /* Start: Check for week */
        $week = date('Y', strtotime("-1 year")) . '-' . date('m') . '-' . date('d', strtotime("+7 days"));
        $userCoursesForWeek = UserCourse::whereDate('end_date', $week)->whereHas('caregiver')->whereHas('course', function($queryMonth) use ($courseAdmin8Title, $courseAdmin12Title,$courseAdmin16Title) {
            return $queryMonth->where('title', $courseAdmin8Title)
                ->orWhere('title', $courseAdmin12Title)
                ->orWhere('title', $courseAdmin16Title);
        })->get();
        foreach ($userCoursesForWeek as $userCourseForWeek) {
            $courseName = $userCourseForWeek->course ? $userCourseForWeek->course->title : '';
            $user = $userCourseForWeek->user ? $userCourseForWeek->user : '';
            $completed_date = $userCourseForWeek->end_date->format('m/d/Y');
            $date1 = date('m/d/Y', strtotime('+1 week'));
            $courseNotPurchased = true;

            switch ($courseName) {
                case $courseAdmin12Title:
                    $subject = 'Your 12 Admin Training Hours are Due in One Week';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForWeek->caregiver->first_name . ' ' . $userCourseForWeek->caregiver->last_name) . ' have one week from today, until ' . $date1 . ', to finish your annual 12 Hour Admin Training. Our records show you last completed your 12 Hour Admin Training on ' . $completed_date . ' and must complete them again within one year of that date. You can find the course <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForWeek->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin16Title:
                    $subject = 'Your 12 Admin Training Hours are Due in One Week';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForWeek->caregiver->first_name . ' ' . $userCourseForWeek->caregiver->last_name) . ' have one week from today, until ' . $date1 . ', to finish your 12 Hour Admin Training. Our records show you completed your 16 Hour Admin Training on ' . $completed_date . ' and must complete 12 subsequent hours within one year of that date. The 12 Hour Admin Training can be found <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForWeek->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin8Title:
                    $subject = 'Your 16 Admin Training Hours are Due in One Week';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForWeek->caregiver->first_name . ' ' . $userCourseForWeek->caregiver->last_name) . ' have one week from today, until ' . $date1 . ', to finish your 16 Hour Admin Training. Our records show you completed your 8 Hour Admin Training on ' . $completed_date . ' and must complete 16 subsequent hours within one year of that date. The 16 Hour Admin Training can be found <a href="' . $link2566 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForWeek->caregiver_id)->where('course_id', $administrators16->id)->count()) {
                        $courseNotPurchased = false;
                    }
            }
            if ($courseNotPurchased && $user && $subject && $body) {
                $this->sendReminderEmail($now, $user, $subject, $body);
            }
        }
        /* End: Check for week */

        /* Start: Check for day */
        $day = date('Y', strtotime("-1 year")) . '-' . date('m') . '-' . date('d', strtotime("+1 days"));
        $userCoursesForDay = UserCourse::whereDate('end_date', $day)->whereHas('caregiver')->whereHas('course', function($queryMonth) use ($courseAdmin8Title, $courseAdmin12Title,$courseAdmin16Title) {
            return $queryMonth->where('title', $courseAdmin8Title)
                ->orWhere('title', $courseAdmin12Title)
                ->orWhere('title', $courseAdmin16Title);
        })->get();
        foreach ($userCoursesForDay as $userCourseForDay) {
            $courseName = $userCourseForDay->course ? $userCourseForDay->course->title : '';
            $user = $userCourseForDay->user ? $userCourseForDay->user : '';
            $completed_date = $userCourseForDay->end_date->format('m/d/Y');
            $date1 = date('m/d/Y', strtotime('+1 day'));
            $courseNotPurchased = true;

            switch ($courseName) {
                case $courseAdmin12Title:
                    $subject = 'Your 12 Admin Training Hours are Due Tomorrow';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForDay->caregiver->first_name . ' ' . $userCourseForDay->caregiver->last_name) . ' have one day, until ' . $date1 . ', to finish your annual 12 Hour Admin Training. Our records show you last completed your 12 Hour Admin Training on ' . $completed_date . ' and must complete them again within one year of that date. You can find the course <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForDay->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin16Title:
                    $subject = 'Your 12 Admin Training Hours are Due Tomorrow';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForDay->caregiver->first_name . ' ' . $userCourseForDay->caregiver->last_name) . ' have one day, until ' . $date1 . ', to finish your 12 Hour Admin Training. Our records show you completed your 16 Hour Admin Training on ' . $completed_date . ' and must complete 12 subsequent hours within one year of that date. The 12 Hour Admin Training can be found <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForDay->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin8Title:
                    $subject = 'Your 16 Admin Training Hours are Due Tomorrow';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForDay->caregiver->first_name . ' ' . $userCourseForDay->caregiver->last_name) . ' have one day, until ' . $date1 . ', to finish your 16 Hour Admin Training. Our records show you completed your 8 Hour Admin Training on ' . $completed_date . ' and must complete 16 subsequent hours within one year of that date. The 16 Hour Admin Training can be found <a href="' . $link2566 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForDay->caregiver_id)->where('course_id', $administrators16->id)->count()) {
                        $courseNotPurchased = false;
                    }
            }
            if ($courseNotPurchased && $user && $subject && $body) {
                $this->sendReminderEmail($now, $user, $subject, $body);
            }
        }
        /* End: Check for day */

        /* Start: Check for today */
        $today = date('Y', strtotime("-1 year")) . '-' . date('m') . '-' . date('d');
        $userCoursesForToday = UserCourse::whereDate('end_date', $today)->whereHas('caregiver')->whereHas('course', function($queryMonth) use ($courseAdmin8Title, $courseAdmin12Title,$courseAdmin16Title) {
            return $queryMonth->where('title', $courseAdmin8Title)
                ->orWhere('title', $courseAdmin12Title)
                ->orWhere('title', $courseAdmin16Title);
        })->get();
        foreach ($userCoursesForToday as $userCourseForToday) {
            $courseName = $userCourseForToday->course ? $userCourseForToday->course->title : '';
            $user = $userCourseForToday->user ? $userCourseForToday->user : '';
            $completed_date = $userCourseForToday->end_date->format('m/d/Y');
            $date1 = date('m/d/Y');
            $courseNotPurchased = true;

            switch ($courseName) {
                case $courseAdmin12Title:
                    $subject = 'Your 12 Admin Training Hours are Due Today';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForToday->caregiver->first_name . ' ' . $userCourseForToday->caregiver->last_name) . ' annual 12 Admin Training Hours are due today, ' . $date1 . '. Our records show you last completed your 12 Hour Admin Training on ' . $completed_date . ' and must complete them again within one year of that date. You can find the course <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForToday->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin16Title:
                    $subject = 'Your 12 Admin Training Hours are Due Today';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForToday->caregiver->first_name . ' ' . $userCourseForToday->caregiver->last_name) . ' 12 administrator hours are due today, ' . $date1 . '. Our records show you completed your 16 Hour Admin Training on ' . $completed_date . ' and must complete 12 subsequent hours within one year of that date. The 12 Hour Admin Training can be found <a href="' . $link4781 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForToday->caregiver_id)->where('course_id', $administrators12->id)->count()) {
                        $courseNotPurchased = false;
                    }
                case $courseAdmin8Title:
                    $subject = 'Your 16 Admin Training Hours are Due Today';
                    $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCourseForToday->caregiver->first_name . ' ' . $userCourseForToday->caregiver->last_name) . ' 16 administrator training hours are due today, ' . $date1 . '. Our records show you completed your 8 Hour Admin Training on ' . $completed_date . ' and must complete 16 subsequent hours within one year of that date. The 16 Hour Admin Training can be found <a href="' . $link2566 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';
                    if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCourseForToday->caregiver_id)->where('course_id', $administrators16->id)->count()) {
                        $courseNotPurchased = false;
                    }
            }
            if ($courseNotPurchased && $user && $subject && $body) {
                $this->sendReminderEmail($now, $user, $subject, $body);
            }
        }
        /* End: Check for today */
    }
}
