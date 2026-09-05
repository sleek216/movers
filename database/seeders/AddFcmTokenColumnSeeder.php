<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFcmTokenColumnSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasColumn('tbl_user', 'fcm_token')) {
            DB::statement("ALTER TABLE `tbl_user` ADD COLUMN `fcm_token` TEXT NULL AFTER `status`;");
        }

        if (!Schema::hasColumn('tbl_lowner', 'fcm_token')) {
            DB::statement("ALTER TABLE `tbl_lowner` ADD COLUMN `fcm_token` TEXT NULL AFTER `status`;");
        }
    }
}
