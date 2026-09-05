<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixCollationSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            'tbl_notification',
            'tbl_user',
            'tbl_lowner',
            'tbl_lorry',
            'tbl_load',
            'tbl_load_response',
            'tbl_faq'
        ];

        foreach ($tables as $table) {
            try {
                DB::statement("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            } catch (\Exception $e) {
                // table might not exist or already utf8mb4
            }
        }
    }
}
