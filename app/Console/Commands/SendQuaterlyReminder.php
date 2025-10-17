<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\UserCourse;
use App\Traits\SendEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendQuaterlyReminder extends Command
{
    use SendEmail;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:quarterly-reminder';

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
     * Execute the console command.
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

        /* Start: Check for every 3 months */
        $userCoursesForEvery3Months = UserCourse::where(function ($query) {
                $query->whereDate('end_date', Carbon::now()->subMonths(3))
                    ->orWhereDate('end_date', Carbon::now()->subMonths(6))
                    ->orWhereDate('end_date', Carbon::now()->subMonths(9))
                    ->orWhereDate('end_date', Carbon::now()->subMonths(12))
                    ->orWhereDate('end_date', Carbon::now()->subMonths(15));
            })
            ->whereHas('caregiver')
            ->whereHas('course', function($queryMonth) use ($courseAdmin8Title) {
                return $queryMonth->where('title', $courseAdmin8Title);
            })
            ->whereHas('user')
            ->get();

        foreach ($userCoursesForEvery3Months as $userCoursesForEvery3Month) {
            $courseName = $userCoursesForEvery3Month->course->title;
            $user = $userCoursesForEvery3Month->user;
            $completed_date = $userCoursesForEvery3Month->end_date->format('m/d/Y');
            $courseNotPurchased = true;

            if ($courseName == $courseAdmin8Title) {
                $subject = 'Your 16 Admin Training Hours are Due';
                $body = '<p>Hello ' . $user->email . ',</p><p>You are receiving this reminder because ' . ($userCoursesForEvery3Month->caregiver->first_name . ' ' . $userCoursesForEvery3Month->caregiver->last_name) . ' have to finish your 16 Hour Admin Training. Our records show you completed your 8 Hour Admin Training on ' . $completed_date . ' and must complete 16 subsequent hours within one year of that date. The 16 Hour Admin Training can be found <a href="' . $link2566 . '" target="_blank" >here</a> at ' . url('/') . '.</p><p>Don’t hesitate to reach out to us if you have any questions. You can respond to this email or give us a call at (713)904-3571.</p><p>Best Regards,</p><p>The 123 Consulting Team</p>';

                if (UserCourse::where('user_id', $user->id)->where('caregiver_id', $userCoursesForEvery3Month->caregiver_id)->where('course_id', $administrators16->id)->count()) {
                    $courseNotPurchased = false;
                }
            }
            if ($courseNotPurchased && $user && $subject && $body) {
                $this->sendReminderEmail($now, $user, $subject, $body);
            }
        }
        /* End: Check for every 3 months */
    }
}
