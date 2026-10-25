<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Which devices saw each ad on which day — one row per (ad, device, day),
// so "unique users" over any period is a COUNT(DISTINCT device_id). The
// device id is an anonymous random id the app generates once per install.
// Impressions stay counted in tbl_ads_premium_stat.views.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_ads_premium_viewer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ads_premium_id');
            $table->string('device_id', 64);
            $table->date('date');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['ads_premium_id', 'date', 'device_id']);
            $table->foreign('ads_premium_id')->references('id')->on('tbl_ads_premium')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_ads_premium_viewer');
    }
};
