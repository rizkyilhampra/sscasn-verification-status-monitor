<?php

namespace App\Console\Commands;

use App\Jobs\GetVerificationStatus;
use App\Models\VerificationStatus;
use Illuminate\Console\Command;

class GetVerificationStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-verification-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'An schedule command to queue scraping API for all verification status.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $verificationStatus = VerificationStatus::all()->each(function ($status) {
            GetVerificationStatus::dispatch($status);
        });

        $this->info('Scraping API of verification status dispatched for '.$verificationStatus->count().' requests.');
    }
}
