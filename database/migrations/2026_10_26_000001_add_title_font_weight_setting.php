<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// App appearance: weight of the serif headline font (section titles,
// greetings…), set from Settings > App and read by the app at startup
// through general_setting. 700 = the weight the app always used.
return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('tbl_general_setting')->where('key', 'title_font_weight')->exists()) {
            DB::table('tbl_general_setting')->insert([
                'key' => 'title_font_weight',
                'value' => '700',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('tbl_general_setting')->where('key', 'title_font_weight')->delete();
    }
};
