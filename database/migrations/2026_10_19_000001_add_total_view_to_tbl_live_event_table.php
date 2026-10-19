<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// View counter for videos/episodes — feeds the Films screen's "Tendances"
// (most viewed) strip. Incremented by the add_video_view API on each play.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->unsignedInteger('total_view')->default(0)->after('episode_number');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->dropColumn('total_view');
        });
    }
};
