<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:get-verification-status-command')
    ->everyTenMinutes();
