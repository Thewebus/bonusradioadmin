<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Since live events were merged into videos (2026_10_18), every
// tbl_live_event row is a video and is_vod was always 1 — no code reads it.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->dropColumn('is_vod');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->integer('is_vod')->default(1)->after('type');
        });
    }
};
