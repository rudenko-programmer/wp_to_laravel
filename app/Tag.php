<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Route;

class Tag extends Model
{
    protected $table = 'tags';

    protected $primaryKey = 'tag_id';

    protected $guarded = [];

    /**
     * Массив полей разрешающих для заполнения
     * @var array
     */
    protected $fillable = [
        'tag_title',
        'tag_slug',
        'hash_url'
    ];

    /**
     * Метод выводит статьи метки
     * @return mixed
     */
    public function posts(){
        return $this->belongsToMany('App\Post','post_tag', 'tag_id', 'post_id');
    }

    static function adminRoutes(){
        /**
         * Маршруты отвечающие за управление метками
         */
        Route::get('/adminpanel/alltags',
            ['as'=>'all_tag_view', 'uses'=>'Admin\AdminTagController@all_tags']);
        Route::post('/adminpanel/addnewtag',
            ['as'=>'new_tag_action', 'uses'=>'Admin\AdminTagController@create_tag']);
        /*
         * Удаляем навсегда
         */
        Route::delete('/adminpanel/deltag/{tag_id}',
            ['as' => 'delete_tag', 'uses' => 'Admin\AdminTagController@del_tag']);
        Route::delete('/adminpanel/delchosetag',
            ['as' => 'delete_chose_tag', 'uses' => 'Admin\AdminTagController@del_chose_tags']);
    }
}
