<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_setting', function (Blueprint $table) {
            $table->string('ai_provider', 50)->default('gemini');
            $table->text('gemini_api_key')->nullable()->after('ai_provider');
            $table->text('openai_api_key')->nullable()->after('gemini_api_key');
            $table->text('google_map_key')->nullable()->after('openai_api_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_setting', function (Blueprint $table) {
            $table->dropColumn(['ai_provider', 'gemini_api_key', 'openai_api_key', 'google_map_key']);
        });
    }
};
