<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Contoh command 'inspire'
Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Menjadwalkan command 'sitemap:generate' agar dijalankan setiap hari
return function (Schedule $schedule) {
    $schedule->command('app:generate-sitemap')->daily();
};
