<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tbl_community_group')) {
            Schema::create('tbl_community_group', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->tinyInteger('is_official')->default(1);
                $table->string('category', 100)->default('General');
                $table->unsignedBigInteger('created_by')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tbl_community_member')) {
            Schema::create('tbl_community_member', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('group_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->string('role', 50)->default('member');
                $table->timestamps();
                $table->unique(['group_id', 'user_id']);
            });
        }

        if (!Schema::hasTable('tbl_community_message')) {
            Schema::create('tbl_community_message', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('group_id')->index();
                $table->unsignedBigInteger('sender_id')->index();
                $table->text('message');
                $table->string('media_url', 500)->nullable();
                $table->string('message_type', 50)->default('text');
                $table->timestamps();
            });
        }

        // Seed 4 Default Official Communities
        $groupsCount = DB::table('tbl_community_group')->count();
        if ($groupsCount == 0) {
            $now = now();
            $g1 = DB::table('tbl_community_group')->insertGetId([
                'title' => '🚚 All Pakistan Transporters & Shippers Hub',
                'description' => 'Official nationwide community to connect freight owners, shippers, and fleet operators. Post loads and discuss rates openly.',
                'icon' => 'truck',
                'is_official' => 1,
                'category' => 'National',
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $g2 = DB::table('tbl_community_group')->insertGetId([
                'title' => '📍 Punjab & Islamabad Freight Network',
                'description' => 'Dedicated regional hub for Lahore, Rawalpindi, Islamabad, Faisalabad, and Multan freight routes.',
                'icon' => 'location',
                'is_official' => 1,
                'category' => 'Regional',
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $g3 = DB::table('tbl_community_group')->insertGetId([
                'title' => '🚛 Karachi Port & Sindh Heavy Freight',
                'description' => 'Flatbed, container, and port transport community connecting Karachi Port, Port Qasim, Hyderabad & Sukkur.',
                'icon' => 'anchor',
                'is_official' => 1,
                'category' => 'Port & Heavy',
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $g4 = DB::table('tbl_community_group')->insertGetId([
                'title' => '⚡ Urgent Daily Loads & Live Rates',
                'description' => 'Fast-track load alerts, spot bidding discussions, and instant truck availability sharing.',
                'icon' => 'bolt',
                'is_official' => 1,
                'category' => 'Spot Rates',
                'created_by' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Add Welcome Messages
            DB::table('tbl_community_message')->insert([
                [
                    'group_id' => $g1,
                    'sender_id' => 1,
                    'message' => 'Welcome to the Official All Pakistan Logistics Hub! 🚚 Feel free to share loads, ask for trucks, and connect with verified drivers.',
                    'message_type' => 'text',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'group_id' => $g2,
                    'sender_id' => 1,
                    'message' => 'Welcome Punjab & Islamabad transporters! Post your daily routes and available lorries here.',
                    'message_type' => 'text',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'group_id' => $g3,
                    'sender_id' => 1,
                    'message' => 'Port Qasim & Karachi Port corridor channel active. Flatbeds and 40ft container movements can be coordinated here.',
                    'message_type' => 'text',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'group_id' => $g4,
                    'sender_id' => 1,
                    'message' => 'Urgent Loads & Spot Bids Channel is live! Share your load details for fast bookings.',
                    'message_type' => 'text',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_community_message');
        Schema::dropIfExists('tbl_community_member');
        Schema::dropIfExists('tbl_community_group');
    }
};
