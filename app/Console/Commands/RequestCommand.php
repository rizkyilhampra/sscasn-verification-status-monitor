<?php

namespace App\Console\Commands;

use App\Jobs\ProcessRequest;
use App\Models\UserRequestHeader;
use Illuminate\Console\Command;

class RequestCommand extends Command
{
    protected $signature = 'scrape:sscasn';

    protected $description = 'Start scraping SSCASN website for all defined UserRequestHeaders.';

    public function handle()
    {
        $userRequestHeaders = UserRequestHeader::all()->each(function ($request) {
            ProcessRequest::dispatch($request);
        });

        $this->info('Scraping jobs dispatched for '.$userRequestHeaders->count().' requests.');
    }
}
