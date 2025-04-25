<?php

use App\Jobs\UpdateWarrantyStatus;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('warranty:update-status', function () {
    UpdateWarrantyStatus::dispatch();
})->everyThreeMinutes();


