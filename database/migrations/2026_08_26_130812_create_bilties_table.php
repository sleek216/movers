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
        Schema::create('tbl_bilties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid')->nullable();
            $table->string('bilty_number', 50)->unique();
            $table->date('bilty_date')->nullable();
            
            // Consignor (Sender / Bhejne Wala)
            $table->string('consignor_name');
            $table->string('consignor_phone', 30)->nullable();
            $table->string('consignor_city', 100);
            $table->text('consignor_address')->nullable();
            
            // Consignee (Receiver / Wasool Karne Wala)
            $table->string('consignee_name');
            $table->string('consignee_phone', 30)->nullable();
            $table->string('consignee_city', 100);
            $table->text('consignee_address')->nullable();
            
            // Cargo / Mal ki Tafseelat
            $table->string('goods_description');
            $table->string('package_type', 50)->default('Nag / Bori');
            $table->integer('total_packages')->default(1);
            $table->decimal('weight_value', 10, 2)->default(0.00);
            $table->string('weight_unit', 20)->default('KG'); // KG, Ton, Maund
            
            // Freight & Payment Details
            $table->decimal('freight_total', 12, 2)->default(0.00);
            $table->decimal('advance_paid', 12, 2)->default(0.00);
            $table->decimal('balance_amount', 12, 2)->default(0.00);
            $table->decimal('loading_charges', 10, 2)->default(0.00);
            $table->string('payment_status', 30)->default('To-Pay'); // Paid, To-Pay, On-Account
            
            // Driver & Truck KYC Verification (Security Layer)
            $table->string('driver_name')->nullable();
            $table->string('driver_phone', 30)->nullable();
            $table->string('driver_cnic', 30)->nullable();
            $table->text('driver_cnic_front')->nullable();
            $table->text('driver_cnic_back')->nullable();
            $table->text('driver_license')->nullable();
            $table->text('driver_photo')->nullable();
            $table->string('truck_number', 50)->nullable();
            $table->string('truck_type', 50)->nullable();
            $table->text('truck_book_photo')->nullable();
            
            // Guarantor / Zamanatdar (Zamanat Record)
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_phone', 30)->nullable();
            $table->string('guarantor_cnic', 30)->nullable();
            $table->text('guarantor_cnic_photo')->nullable();
            $table->string('guarantor_relation', 100)->nullable(); // Adda Malik, Known Agent, Relative
            $table->text('guarantor_note')->nullable();
            
            // Status & Remarks
            $table->string('status', 30)->default('Booked'); // Booked, In-Transit, Delivered, Cancelled
            $table->text('remarks')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_bilties');
    }
};
