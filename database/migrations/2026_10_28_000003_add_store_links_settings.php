<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Store pages of the app (Settings > App), read by the app at startup: the
// radio player's share message only links to the app when one is filled.
// - play_store_url: Google Play page.
// - app_store_url: App Store page.
return new class extends Migration
{
    private $settings = [
        'play_store_url' => '',
        'app_store_url' => '',
    ];

    public function up(): void
    {
        foreach ($this->settings as $key => $value) {
            if (!DB::table('tbl_general_setting')->where('key', $key)->exists()) {
                DB::table('tbl_general_setting')->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('tbl_general_setting')->whereIn('key', array_keys($this->settings))->delete();
    }
};
