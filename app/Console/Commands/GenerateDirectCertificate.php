<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use App\Traits\GenerateCertificate;
use Illuminate\Console\Command;

class GenerateDirectCertificate extends Command
{
    use GenerateCertificate;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:cert';

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
        $certificate_id = $this->ask("What is the certificate ID?");
        $certificate_name = $this->ask("Enter name for the certificate");
        $course_name = $this->ask("Enter course name");
        $date = $this->ask("Enter date (April 27, 2023)");
        $certificate = Certificate::find($certificate_id);
        $file = $this->generatePdf($certificate, $certificate_name, $course_name, $date);
        $this->line($file);
    }
}
