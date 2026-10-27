<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Mobile data reminder (Settings > App), read by the app at startup:
// - mobile_data_warning: show a discreet reminder while streaming on mobile
//   data (1) or never (0).
// - mobile_data_warning_mb: estimated MB used on mobile data in the session
//   before the first reminder.
// - mobile_data_warning_interval: minimum minutes between two reminders.
return new class extends Migration
{
    private $settings = [
        'mobile_data_warning' => '1',
        'mobile_data_warning_mb' => '100',
        'mobile_data_warning_interval' => '30',
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
