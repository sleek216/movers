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
        if (!Schema::hasTable('tbl_user_driver')) {
            Schema::create('tbl_user_driver', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id')->index(); // Transporter/Owner ID
                $table->string('name', 150);
                $table->string('phone', 50);
                $table->string('photo', 255)->nullable();
                $table->string('vehicle_type', 100)->nullable(); // e.g. 22-Wheeler, Mazda, Shehzore, Trailer
                $table->string('vehicle_number', 50)->nullable(); // e.g. LES-2024
                $table->string('primary_route', 200)->nullable(); // e.g. Lahore - Karachi
                $table->string('cnic', 50)->nullable();
                $table->string('license_number', 50)->nullable();
                $table->string('experience_years', 50)->nullable();
                $table->string('status', 30)->default('active'); // active, on_trip, inactive
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_driver');
    }
};
