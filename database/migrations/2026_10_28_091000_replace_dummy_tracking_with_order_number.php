<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ganti semua nomor resi dummy lama (yang berformat BV-XXXXXXXX acak 8 karakter)
        // dengan order_number pesanan yang sebenarnya.
        DB::table('orders')
            ->where('tracking_number', '!=', 'DIGITAL-ACCESS')
            ->where('tracking_number', 'LIKE', 'BV-%')
            ->whereRaw('LENGTH(tracking_number) < 15') // Kode acak lama panjangnya 11 karakter (BV-XXXXXXXX)
            ->update([
                'tracking_number' => DB::raw('order_number')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu revert karena order_number lebih valid daripada dummy string
    }
};

