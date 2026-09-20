<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Video-on-demand rows live in tbl_live_event next to the live events.
 * is_vod separates them so every existing event query keeps returning
 * exactly what it returned before (is_vod defaults to 0).
 */
class AddVideoColumnsToTblLiveEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->integer('is_vod')->default(0)->comment('0-Live event, 1-Video on demand')->after('type');
            $table->integer('category_id')->nullable()->comment('tbl_video_category.id (video on demand only)')->after('is_vod');
            $table->integer('video_source')->default(1)->comment('1-External link, 2-Uploaded file (link holds the file name)')->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->dropColumn(['is_vod', 'category_id', 'video_source']);
        });
    }
}
