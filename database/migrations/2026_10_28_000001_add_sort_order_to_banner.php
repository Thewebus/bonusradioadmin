<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Home banners get an admin-defined display order. Existing banners keep
// the order they were shown in until now (newest first).
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_banner', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('content_id');
        });
        foreach (DB::table('tbl_banner')->orderBy('id', 'desc')->pluck('id') as $i => $id) {
            DB::table('tbl_banner')->where('id', $id)->update(['sort_order' => $i + 1]);
        }
    }

    public function down(): void
    {
        Schema::table('tbl_banner', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
