<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts/get_posts', 'PostController@apiGetPosts')->name('get_posts');
Route::get('/media/upload_media/{id}', 'Admin\AdminMediaController@apiGetUploadImages')->name('get_upload_media');
Route::delete('/media/delete_media/{id}', 'Admin\AdminMediaController@apiDeleteImages');
Route::get('/media/get_media', 'Admin\AdminMediaController@apiGetImages')->name('get_media');