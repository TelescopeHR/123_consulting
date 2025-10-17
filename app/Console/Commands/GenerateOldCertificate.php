<?php

namespace App\Console\Commands;

use App\Traits\GenerateCertificate;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateOldCertificate extends Command
{
    use GenerateCertificate;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'old-certificate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate old certificate, only one time use';

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
        $csvToRead = fopen(public_path('old_certificate_all.csv'), 'r');

        while (! feof($csvToRead)) {
            $row = fgetcsv($csvToRead, 1000, ',');
            $this->line($row);
            if ($row[0] && $row[1] && $row[2] && $row[3] && $row[4]) {
                $username = $row[1];
                $email = $row[2];
                $coursesName = explode(' - ', $row[3])[0];
                if ($row[4] != '01-01-1970') {
                    $completeDate = Carbon::parse($row[4])->format('F d, Y');
                    $this->generateOldPdf($username, $email, $coursesName, $completeDate);
                }
            }
        }
        // $this->generateOldPdf('certificate', 'John Doe', '$request->title', date('F d, Y'));
    }
}
