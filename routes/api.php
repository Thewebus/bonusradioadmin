<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;

Route::group(['middleware' => 'apipurchasecode'], function () {

    // -------------------- UserController --------------------
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('get_profile', [UserController::class, 'get_profile']);
    Route::post('update_profile', [UserController::class, 'update_profile']);

    // -------------------- HomeController --------------------
    Route::post('general_setting', [HomeController::class, 'general_setting']);
    Route::post('get_payment_option', [HomeController::class, 'get_payment_option']);
    Route::post('get_pages', [HomeController::class, 'get_pages']);
    Route::post('get_onboarding_screen', [HomeController::class, 'get_onboarding_screen']);
    Route::post('get_social_link', [HomeController::class, 'get_social_link']);
    Route::post('get_city', [HomeController::class, 'get_city']);
    Route::post('get_artist', [HomeController::class, 'get_artist']);
    Route::post('get_category', [HomeController::class, 'get_category']);
    Route::post('get_language', [HomeController::class, 'get_language']);
    Route::post('get_package', [HomeController::class, 'get_package']);
    Route::post('add_transaction', [HomeController::class, 'add_transaction']);
    Route::post('transaction_list', [HomeController::class, 'transaction_list']);
    Route::post('get_radio_by_city', [HomeController::class, 'get_radio_by_city']);
    Route::post('get_radio_by_artist', [HomeController::class, 'get_radio_by_artist']);
    Route::post('get_radio_by_language', [HomeController::class, 'get_radio_by_language']);
    Route::post('get_radio_by_category', [HomeController::class, 'get_radio_by_category']);
    Route::post('get_latest_song', [HomeController::class, 'get_latest_song']);
    Route::post('get_popular_song', [HomeController::class, 'get_popular_song']);
    Route::post('get_latest_podcast', [HomeController::class, 'get_latest_podcast']);
    Route::post('get_popular_podcast', [HomeController::class, 'get_popular_podcast']);
    Route::post('get_live_event', [HomeController::class, 'get_live_event']);
    Route::post('search_content', [HomeController::class, 'search_content']);
    Route::post('get_section_list', [HomeController::class, 'get_section_list']);
    Route::post('get_section_detail', [HomeController::class, 'get_section_detail']);
    Route::post('get_banner', [HomeController::class, 'get_banner']);
    Route::post('add_remove_favorite', [HomeController::class, 'add_remove_favorite']);
    Route::post('get_favorite_list', [HomeController::class, 'get_favorite_list']);
    Route::post('join_live_event', [HomeController::class, 'join_live_event']);
    Route::post('get_episode_by_podcast', [HomeController::class, 'get_episode_by_podcast']);
    Route::post('get_notification', [HomeController::class, 'get_notification']);
    Route::post('read_notification', [HomeController::class, 'read_notification']);
    Route::post('add_play', [HomeController::class, 'add_play']);
    Route::post('add_comment', [HomeController::class, 'add_comment']);
    Route::post('get_comment', [HomeController::class, 'get_comment']);
    Route::post('edit_comment', [HomeController::class, 'edit_comment']);
    Route::post('delete_comment', [HomeController::class, 'delete_comment']);
    Route::post('get_podcast_section_list', [HomeController::class, 'get_podcast_section_list']);
    Route::post('get_podcast_section_detail', [HomeController::class, 'get_podcast_section_detail']);
    // ==============================Un Use=====================================
    Route::post('get_radio_banner', [HomeController::class, 'get_radio_banner']);
    Route::post('get_podcast_banner', [HomeController::class, 'get_podcast_banner']);
});
