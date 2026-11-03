<?php

use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Perintah Pembatalan Otomatis Pesanan Kedaluwarsa (24 Jam)
 */
Artisan::command('orders:cancel-expired', function () {
    $count = Order::cancelAllExpired();
    $this->info("[Auto-Cancel] Berhasil membatalkan {$count} pesanan kedaluwarsa.");
})->purpose('Batalkan otomatis pesanan pending yang melewati batas pembayaran 24 jam');

Schedule::command('orders:cancel-expired')->everyFiveMinutes();
