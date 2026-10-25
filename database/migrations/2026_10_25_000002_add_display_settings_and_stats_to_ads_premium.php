<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Ads (the app's radio-screen "zone pub" slideshow), now driven from the
// backend: an uploaded poster (or an external image URL), how long it stays
// on screen, an optional click-through link, and per-day view/click counts.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_ads_premium', function (Blueprint $table) {
            $table->string('image')->nullable()->after('crea_name');
            $table->text('image_url')->nullable()->change();
            $table->text('link_url')->nullable()->after('image_url');
            $table->unsignedSmallInteger('display_duration')->default(12)->after('link_url');
        });

        // One row per ad per day — counters incremented by the app.
        Schema::create('tbl_ads_premium_stat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ads_premium_id');
            $table->date('date');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->timestamps();
            $table->unique(['ads_premium_id', 'date']);
            $table->foreign('ads_premium_id')->references('id')->on('tbl_ads_premium')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_ads_premium_stat');
        Schema::table('tbl_ads_premium', function (Blueprint $table) {
            $table->dropColumn(['image', 'link_url', 'display_duration']);
        });
    }
};
