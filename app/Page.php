<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Route;

class Page extends Model
{
    protected $table = 'pages';

    protected $primaryKey = 'page_id';

    protected $guarded = [];

    /**
     * Массив полей разрешающих для заполнения
     * @var array
     */
    protected $fillable = [
        'page_title',
        'page_slug',
        'page_content',
        'page_thumbnail',
        'page_status',
        'page_author',
        'hash_url',
        'meta_description',
        'meta_keywords',
        'meta_img',
    ];

    /**
     * Метод возвращает автора страницы
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(){
        return $this->belongsTo('App\User','page_author', 'user_id');
    }

    /**
     * @return string
     */
    public function thumbnail(){
        return Media::getImg($this->page_thumbnail,'thumbnail');
    }

    /**
     * @return string
     */
    public function img(){
        return Media::getImg($this->page_thumbnail,'full');
    }

    /**
     * @param $id
     * @param $value
     */
    static function addPhoto($id, $value){
        $post = Page::findOrFail($id);
        $post->page_thumbnail = $value;
        $post->save();
    }

    /**
     * @param $status
     */
    public function setStatus($status){
        switch ($status){
            case 'publish':
            case 'draft':
            case 'trash':
                $this->page_status = $status;
                break;
            default: $this->page_status = 'draft';
        }
    }

    /**
     * Метод помещает страницу в корзину
     */
    public function toTrash(){
        $this->page_status = "trash";
        $this->save();
    }

    /**
     * Метод востанавливает елемент с корзины и помещает страницу в черновики
     */
    public function restore(){
        $this->page_status = "draft";
        $this->save();
    }

    /**
     * Устанавливаем ХЕШ страници
     * @param $hash
     */
    public function setHash($hash){
        $this->hash_url = sha1($hash);
    }

    static function adminRoutes(){
        /**
         * Маршруты отвечают за управление страницами
         */
        Route::get('/adminpanel/newpage',
            ['as'=>'new_page_view', 'uses'=>'Admin\AdminPageController@new_page']);
        Route::get('/adminpanel/allpages',
            ['as'=>'all_page_view', 'uses'=>'Admin\AdminPageController@all_pages']);
        Route::get('/adminpanel/trashpages',
            ['as'=>'trash_page_view', 'uses'=>'Admin\AdminPageController@all_trash_pages']);
        Route::get('/adminpanel/page/{page_id}',
            ['as'=>'edit_page_view', 'uses'=>'Admin\AdminPageController@get_page']);
        Route::put('/adminpanel/editpage',
            ['as'=>'edit_page_action', 'uses'=>'Admin\AdminPageController@edit_page']);
        Route::post('/adminpanel/addnewpage',
            ['as'=>'create_page_action', 'uses'=>'Admin\AdminPageController@add_new_page']);
        /*
         * Удаляем навсегда
         */
        Route::delete('/adminpanel/delpage/{page_id}',
            ['as' => 'delete_page', 'uses' => 'Admin\AdminPageController@del_page']);
        Route::delete('/adminpanel/delchosepage',
            ['as' => 'delete_chose_page', 'uses' => 'Admin\AdminPageController@del_chose_page']);
        /*
         * Помещаем в корзину
         */
        Route::delete('/adminpanel/pagetotrash/{page_id}',
            ['as' => 'to_trash_page', 'uses' => 'Admin\AdminPageController@moveToTrash']);
        Route::delete('/adminpanel/chosepagetotrash',
            ['as' => 'to_trash_chose_page', 'uses' => 'Admin\AdminPageController@moveToTrashChosen']);
        /*
         * Восстанавливаем категорию из корзины
         */
        Route::post('/adminpanel/restorpage/{page_id}',
            ['as' => 'restore_page', 'uses' => 'Admin\AdminPageController@restorePage']);
    }
}
