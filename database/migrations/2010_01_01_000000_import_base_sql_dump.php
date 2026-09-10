<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sqlPath = database_path('MoversDB.sql');
        
        if (File::exists($sqlPath)) {
            $sql = File::get($sqlPath);
            DB::unprepared($sql);
        } else {
            throw new Exception("Base database dump MoversDB.sql not found at {$sqlPath}. Please make sure the file is uploaded.");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Dropping all tables since this is a base dump
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_{$dbName}"};
            DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
