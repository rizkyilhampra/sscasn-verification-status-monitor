<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('scrape:sscasn')->everyFiveMinutes();
