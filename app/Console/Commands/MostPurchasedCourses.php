<?php

namespace App\Console\Commands;

use App\Models\OldPurchase;
use App\Models\UserCourse;
use App\Traits\MondayComTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MostPurchasedCourses extends Command
{
    use MondayComTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'most:purchased';

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
        $userCourses = UserCourse::select('*', DB::raw('COUNT(*) as count'))->whereHas('user')->groupBy('user_id')->orderBy('count', 'desc')->get();

        $oldPurchases = OldPurchase::select('*', DB::raw('COUNT(*) as count'))->whereHas('user')->groupBy('user_id')->orderBy('count', 'desc')->get();

        $data = [];
        foreach ($userCourses as $course) {
            if ($course->count > 1) {
                $this->line($course->user->first_name . ' ' . $course->user->last_name . " -> " . $course->count);
                $data[$course->user->id] = [
                    'user_id' => $course->user->id,
                    'first_name' => $course->user->first_name,
                    'last_name' => $course->user->last_name,
                    'email' => $course->user->email,
                    'count' => $course->count
                ];
            }
        }

        foreach ($oldPurchases as $oldPurchase) {
            if ($oldPurchase->count > 1) {
                $this->line($oldPurchase->user->first_name . ' ' . $oldPurchase->user->last_name . " -> " . $oldPurchase->count);
                if (isset($data[$oldPurchase->user->id]) && $data[$oldPurchase->user->id]) {
                    $data[$oldPurchase->user->id] = [
                        'user_id' => $oldPurchase->user->id,
                        'first_name' => $oldPurchase->user->first_name,
                        'last_name' => $oldPurchase->user->last_name,
                        'email' => $oldPurchase->user->email,
                        'count' => $data[$oldPurchase->user->id]['count'] + $oldPurchase->count
                    ];
                } else {
                    $data[$oldPurchase->user->id] = [
                        'user_id' => $oldPurchase->user->id,
                        'first_name' => $oldPurchase->user->first_name,
                        'last_name' => $oldPurchase->user->last_name,
                        'email' => $oldPurchase->user->email,
                        'count' => $oldPurchase->count
                    ];
                }
            }
        }

        foreach ($data as $value) {
            $this->addMostPurchased([
                'first_name' => $value['first_name'],
                'last_name' => $value['last_name'],
                'email' => $value['email'],
                'count' => $value['count'],
            ]);
        }
        return 0;
    }
}
