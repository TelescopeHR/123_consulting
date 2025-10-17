<?php

namespace App\Console\Commands;

use App\Models\UserCourse;
use App\Traits\SendEmail;
use Illuminate\Console\Command;

class WeeklyReport extends Command
{
    use SendEmail;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:report';

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
        $start_date = date('Y-m-d', strtotime('-7 Days'));
        $lastWeekCourses = UserCourse::whereHas('course')
            ->whereHas('user')
            ->whereHas('caregiver')
            ->whereDate('end_date', '>=', $start_date)
            ->get();

        $data = [
            ['Agency', 'Agency Email', 'Caregiver Name', 'Caregiver Email', 'Caregiver Phone', 'Course', 'Completed On']
        ];

        if ($lastWeekCourses && count($lastWeekCourses)) {
            foreach ($lastWeekCourses as $lastWeekCourse) {
                $data[] = [
                    $lastWeekCourse->user->agency_name,
                    $lastWeekCourse->user->email,
                    $lastWeekCourse->caregiver->first_name . ' ' . $lastWeekCourse->caregiver->last_name,
                    $lastWeekCourse->caregiver->email,
                    $lastWeekCourse->caregiver->phone,
                    $lastWeekCourse->course->title,
                    $lastWeekCourse->end_date->format('m/d/Y')
                ];
            }

            $filename = date('Y-m-d') . '-123consulting.csv';
            $this->array2csv($data, $filename);

            $subject = 'Weekly Report For Help - 123 Consulting Solutions';
            $this->sendWeelyReportEmail($filename, $subject);
        }
    }

    /* Create csv file from array of data */
    function array2csv($data, $filename)
    {
        $destinationPath = public_path('weekly-files/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $f = fopen(public_path('weekly-files/' . $filename), 'w');
        foreach ($data as $item) {
            fputcsv($f, $item);
        }
        fclose($f);
        return true;
    }
}
