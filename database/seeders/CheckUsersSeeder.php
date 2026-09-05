<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('tbl_user')->select('id', 'name', 'mobile', 'fcm_token', 'is_verify')->get();
        foreach ($users as $u) {
            echo "ID: {$u->id} | Name: {$u->name} | Verify: {$u->is_verify} | FCM: " . ($u->fcm_token ? 'EXISTS (' . substr($u->fcm_token, 0, 15) . '...)' : 'NULL') . "\n";
        }
    }
}
