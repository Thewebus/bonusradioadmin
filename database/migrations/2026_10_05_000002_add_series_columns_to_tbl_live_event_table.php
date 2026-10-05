<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nullable, defaults to null on every existing row: standalone videos and
 * live events keep behaving exactly as before. Only a video explicitly
 * attached to a series (video_series_id set) becomes an episode.
 */
class AddSeriesColumnsToTblLiveEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_live_event', function (Blueprint $table) {
            $table->unsignedBigInteger('video_series_id')->nullable()->comment('tbl_video_series.id (video on demand only)')->after('video_source');
            $table->integer('episode_number')->nullable()->after('video_series_id');
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
            $table->dropColumn(['video_series_id', 'episode_number']);
        });
    }
}
