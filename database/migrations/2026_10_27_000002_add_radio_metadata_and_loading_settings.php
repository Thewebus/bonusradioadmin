<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// App appearance settings (Settings > App), read by the app at startup:
// - show_radio_metadata: show the live song/cover/listeners from AzuraCast
//   on the Radios screen and mini-player (1) or not (0).
// - thumbnail_loading: what a thumbnail shows while loading — an animated
//   shimmer ("shimmer") or the logo picture ("image").
return new class extends Migration
{
    private $settings = [
        'show_radio_metadata' => '1',
        'thumbnail_loading' => 'shimmer',
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
