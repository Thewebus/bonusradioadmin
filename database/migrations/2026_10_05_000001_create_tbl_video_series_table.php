<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A series is just a header (title/image/description) — its episodes are
 * ordinary tbl_live_event rows (is_vod=1) pointed at it via video_series_id,
 * so the whole upload/payment/unlock pipeline already built for standalone
 * videos keeps working unchanged for episodes too.
 */
class CreateTblVideoSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_video_series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('portrait_img')->nullable();
            $table->string('landscape_img')->nullable();
            $table->unsignedBigInteger('category_id')->nullable()->comment('tbl_video_category.id');
            $table->integer('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_video_series');
    }
}
