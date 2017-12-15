<?php

use App\Category;
use App\Page;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'PageController@mainPage');

Auth::routes();
Route::get('/auth/{provider}/redirect', ['as'=>'social_redirect', 'uses'=>'SocialAuthController@redirect']);
Route::get('/auth/{provider}/callback', ['as'=>'social_callback', 'uses'=>'SocialAuthController@callback']);
Route::group(['middleware' => ['auth', 'admin']], function (){
        Route::get('/adminpanel', 'AdminPanelController@index');
        Route::get('/adminpanel/media', 'AdminPanelController@index');
        Route::get('/adminpanel/wpimporter', 'AdminPanelController@wpimporter');
        Route::put('/adminpanel/wpimporter/load',
            ['as' => 'wp_load_xml', 'uses' => 'AdminPanelController@wp_load_xml']);
        Route::put('/adminpanel/wpimporter/doxml',
            ['as' => 'wp_do_xml', 'uses' => 'AdminPanelController@wp_do_xml']);
        Route::put('/adminpanel/wpimporter/ajaxxml',
            ['as' => 'wp_do_ajax_xml', 'uses' => 'AdminPanelController@wp_do_ajax_xml']);

        Post::adminRoutes();

        Category::adminRoutes();

        Page::adminRoutes();

        Tag::adminRoutes();

        /**
         * Маршруты отвечают за управление пользователями
         */
        Route::get('/adminpanel/newuser',
            ['as'=>'new_user_view', 'uses'=>'Admin\AdminUserController@newUser']);
        Route::get('/adminpanel/allusers',
            ['as'=>'all_user_view', 'uses'=>'Admin\AdminUserController@allUser']);
        Route::get('/adminpanel/user/{user_id}',
            ['as'=>'edit_user_view','uses' => 'Admin\AdminUserController@getUser']);
        Route::put('/adminpanel/edituser',
            ['as'=>'edit_user_action','uses' => 'Admin\AdminUserController@editUser']);
        Route::post('/adminpanel/addnewuser',
            ['as'=>'create_user_action','uses' => 'Admin\AdminUserController@createUser']);

        /**
         * Добавление медиафайла
         */
        Route::get('/adminpanel/media', 'Admin\AdminMediaController@media');
        Route::post('/adminpanel/media/photos',
            ['as' => 'store_photo_path', 'uses' => 'Admin\AdminMediaController@addPhoto']);
        Route::delete('/adminpanel/media/delete/{id}', 'Admin\AdminMediaController@destroy');

        Route::put('/adminpanel/addphoto/{type}/{id}',
            ['as' => 'add_photo_to', 'uses' => 'Admin\AdminMediaController@addPhotoTo']);
        Route::get('/adminpanel/viewaddphoto/{type}/{id}', 'Admin\AdminMediaController@viewAddPhotoTo');

});

Route::get('/blog','PostController@blogPage');
Route::get('/vueblog','PostController@vueBlogPage');
Route::get('/post/{post_slug}',
    ['as'=>'single_blog_page', 'uses'=>'PostController@singleBlogPage']);
Route::get('/amp/{post_slug}',
    ['as'=>'amp_single_blog_page', 'uses'=>'PostController@ampSingleBlogPage']);
Route::get('/category/{cut_slug}',
    ['as'=>'cat_page', 'uses'=>'CategoriesController@categoryPage']);
Route::get('/tag/{tag_slug}',
    ['as'=>'tag_page', 'uses'=>'TagController@tagPage']);
Route::get('/{page_slug}',
    ['as'=>'page', 'uses'=>'PageController@singlePage']);
Route::get('/{category_slug}/{post_slug}',
    ['as'=>'single_blog_page_with_cat', 'uses'=>'PostController@singleBlogPageWithCat']);

