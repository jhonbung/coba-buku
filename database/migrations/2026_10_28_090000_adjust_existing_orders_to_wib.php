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
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::table('orders')->update([
                'created_at' => DB::raw("datetime(created_at, '+7 hours')"),
                'updated_at' => DB::raw("datetime(updated_at, '+7 hours')"),
            ]);

            if (DB::getSchemaBuilder()->hasTable('chat_messages')) {
                DB::table('chat_messages')->update([
                    'created_at' => DB::raw("datetime(created_at, '+7 hours')"),
                    'updated_at' => DB::raw("datetime(updated_at, '+7 hours')"),
                ]);
            }
        } else {
            DB::table('orders')->update([
                'created_at' => DB::raw("DATE_ADD(created_at, INTERVAL 7 HOUR)"),
                'updated_at' => DB::raw("DATE_ADD(updated_at, INTERVAL 7 HOUR)"),
            ]);

            if (DB::getSchemaBuilder()->hasTable('chat_messages')) {
                DB::table('chat_messages')->update([
                    'created_at' => DB::raw("DATE_ADD(created_at, INTERVAL 7 HOUR)"),
                    'updated_at' => DB::raw("DATE_ADD(updated_at, INTERVAL 7 HOUR)"),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::table('orders')->update([
                'created_at' => DB::raw("datetime(created_at, '-7 hours')"),
                'updated_at' => DB::raw("datetime(updated_at, '-7 hours')"),
            ]);

            if (DB::getSchemaBuilder()->hasTable('chat_messages')) {
                DB::table('chat_messages')->update([
                    'created_at' => DB::raw("datetime(created_at, '-7 hours')"),
                    'updated_at' => DB::raw("datetime(updated_at, '-7 hours')"),
                ]);
            }
        } else {
            DB::table('orders')->update([
                'created_at' => DB::raw("DATE_SUB(created_at, INTERVAL 7 HOUR)"),
                'updated_at' => DB::raw("DATE_SUB(updated_at, INTERVAL 7 HOUR)"),
            ]);

            if (DB::getSchemaBuilder()->hasTable('chat_messages')) {
                DB::table('chat_messages')->update([
                    'created_at' => DB::raw("DATE_SUB(created_at, INTERVAL 7 HOUR)"),
                    'updated_at' => DB::raw("DATE_SUB(updated_at, INTERVAL 7 HOUR)"),
                ]);
            }
        }
    }
};

