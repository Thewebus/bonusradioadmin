<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// One category system for everything: songs, podcasts, videos and series
// all use tbl_category from now on. Each video category is matched to the
// general category with the same name (created when missing), then videos,
// series and Video home sections are re-pointed to it. tbl_video_category
// itself is kept untouched so down() can restore the old ids.
return new class extends Migration
{
    public function up(): void
    {
        $map = $this->videoToGeneralMap(true);
        $this->remap($map);
    }

    public function down(): void
    {
        $map = $this->videoToGeneralMap(false);
        $this->remap(array_flip($map));
    }

    // [video category id => general category id], matched by name.
    private function videoToGeneralMap(bool $createMissing): array
    {
        $map = [];
        foreach (DB::table('tbl_video_category')->get() as $videoCategory) {
            $name = trim($videoCategory->name);
            $general = DB::table('tbl_category')
                ->whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower($name)])
                ->first();
            if (!$general && $createMissing) {
                $id = DB::table('tbl_category')->insertGetId([
                    'name' => $name,
                    'image' => '',
                    'status' => $videoCategory->status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $general = (object) ['id' => $id];
            }
            if ($general) {
                $map[(int) $videoCategory->id] = (int) $general->id;
            }
        }
        return $map;
    }

    // One UPDATE per table with a CASE, so ids that overlap between the two
    // tables are never remapped twice.
    private function remap(array $map): void
    {
        if (empty($map)) {
            return;
        }
        $case = 'CASE category_id';
        $bindings = [];
        foreach ($map as $from => $to) {
            $case .= ' WHEN ? THEN ?';
            $bindings[] = $from;
            $bindings[] = $to;
        }
        $case .= ' ELSE category_id END';
        $in = implode(',', array_fill(0, count($map), '?'));
        $ids = array_keys($map);

        DB::update("UPDATE tbl_live_event SET category_id = $case WHERE category_id IN ($in)", array_merge($bindings, $ids));
        DB::update("UPDATE tbl_video_series SET category_id = $case WHERE category_id IN ($in)", array_merge($bindings, $ids));
        DB::update("UPDATE tbl_section SET category_id = $case WHERE type = 8 AND category_id IN ($in)", array_merge($bindings, $ids));
    }
};
