<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration, not a schema change — is_vod/category_id already exist on
 * tbl_live_event. "Live event" had no real-time semantics left (start_time/
 * end_time were parsed but never read anywhere in the app); this folds the
 * handful of is_vod=0 rows into the video catalog as ordinary videos, and
 * the one type=3 ("Live Event") section into a type=8 ("Vidéo") section.
 */
class MergeLiveEventsIntoVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            $seriesCategoryId = DB::table('tbl_video_category')->where('name', 'Séries')->value('id');
            if (!$seriesCategoryId) {
                throw new RuntimeException('tbl_video_category "Séries" not found — pick a target category before running this migration.');
            }

            DB::table('tbl_live_event')->where('is_vod', 0)->update([
                'is_vod' => 1,
                'category_id' => $seriesCategoryId,
            ]);

            DB::table('tbl_section')->where('type', 3)->update([
                'type' => 8,
                'category_id' => $seriesCategoryId,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Best-effort only: every row that was is_vod=0 had category_id=null
        // before this ran, and every tbl_section row that was type=3 is now
        // type=8 — there's no reliable way to tell which rows those were
        // without a snapshot, so this migration is intended as one-shot.
    }
}
