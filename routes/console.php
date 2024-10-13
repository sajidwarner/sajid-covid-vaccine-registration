<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:schedule-vaccinations')->withoutOverlapping()
                                            ->runInBackground()
                                            ->everyMinute();

Schedule::command('app:send-vaccination-reminders')->withoutOverlapping()
                                            ->runInBackground()
                                            ->dailyAt('21:00');


