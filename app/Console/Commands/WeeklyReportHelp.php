<?php

namespace App\Console\Commands;

use App\Models\CartHelp;
use App\Traits\SendEmail;
use Illuminate\Console\Command;

class WeeklyReportHelp extends Command
{
    use SendEmail;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly:report-help';

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
        $cartHelps = CartHelp::whereHas('user')
            ->where('is_sent', 0)
            ->get();

        $data = [
            ['Agency', 'Agency Email', 'Phone', 'Need Help On']
        ];

        if ($cartHelps && count($cartHelps)) {
            foreach ($cartHelps as $cartHelp) {
                $data[] = [
                    $cartHelp->user->agency_name,
                    $cartHelp->user->email,
                    $cartHelp->user->phone,
                    $cartHelp->help
                ];
            }

            CartHelp::whereHas('user')->where('is_sent', 0)->update([
                'is_sent' => 1
            ]);

            $filename = date('Y-m-d') . '-help-123consulting.csv';
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
