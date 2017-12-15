<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Route;

class Post extends Model
{

    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    protected $guarded = [];

    /**
     * Массив полей разрешающих для заполнения
     * @var array
     */
    protected $fillable = [
        'post_title',
        'post_slug',
        'post_content',
        'post_thumbnail',
        'post_status',
        'post_author',
        'hash_url',
        'meta_description',
        'meta_keywords',
        'meta_img',
        'main_cat'
    ];

    /**
     * Метод возвращает список комментариев статьи
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany('App\Comments', 'comment_post', 'post_id');
    }

    /**
     * Метод возвращает автора статьи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(){
        return $this->belongsTo('App\User','post_author', 'user_id');
    }

    /**
     * Метод возвращает список категорий статьи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(){
        return $this->belongsToMany('App\Category','category_post', 'post_id', 'cat_id');
    }

    /**
     * Метод выводит метки статьи
     * @return mixed
     */
    public function tags(){
        return $this->belongsToMany('App\Tag','post_tag', 'post_id', 'tag_id');
    }

    /**
     * Метод выводит миниатюру
     * @return string
     */
    public function thumbnail(){
        return Media::getImg($this->post_thumbnail,'thumbnail');
    }

    /**
     * Метод выводить полную картинку
     * @return string
     */
    public function img(){
        return Media::getImg($this->post_thumbnail,'full');
    }

    /**
     * Метод добавляет картинку к посту
     * @param $id
     * @param $value
     */
    static function addPhoto($id, $value){
        $post = Post::findOrFail($id);
        $post->post_thumbnail = $value;
        $post->save();
    }

    /**
     * Метод устанавливат значение статуса
     * @param $status
     */
    public function setStatus($status){
        switch ($status){
            case 'publish':
            case 'draft':
            case 'trash':
                $this->post_status = $status;
                break;
            default: $this->post_status = 'draft';
        }
    }

    /**
     * Метод помещает статью в корзину
     */
    public function toTrash(){
        $this->post_status = "trash";
        $this->save();
    }

    /**
     * Метод востанавливает елемент с корзины и помещает статью в черновики
     */
    public function restore(){
        $this->post_status = "draft";
        $this->save();
    }

    /**
     * Метод вырезает необходимое количество символов
     * @param int $word_nums
     * @return string
     */
    public function excerpt($word_nums = 250){
        /*
         * mb_substr позволяет коректно вырезать кирилицу
         */
        return mb_substr(strip_tags($this->post_content), 0, $word_nums).' ...';
    }

    /**
     * Устанавливаем ХЕШ статьи
     * @param $hash
     */
    public function setHash($hash){
        $this->hash_url = sha1($hash);
    }

    static function lastPost($count = 5){
        return Post::where('post_status','<>','trash')
            ->orderBy('created_at','desc')
            ->limit($count)
            ->get();
    }

    /**
     * Маршруты статей в админке
     */
    static function adminRoutes(){
            Route::get('/adminpanel/newpost',
                ['as' => 'new_post_view', 'uses' => 'Admin\AdminPostController@new_post']);
            Route::get('/adminpanel/allposts',
                ['as' => 'all_post_view', 'uses' => 'Admin\AdminPostController@all_posts']);
            Route::get('/adminpanel/trashposts',
                ['as' => 'trash_post_view', 'uses' => 'Admin\AdminPostController@all_trash_posts']);
            Route::get('/adminpanel/post/{post_id}',
                ['as' => 'edit_post_view', 'uses' => 'Admin\AdminPostController@get_post']);
            Route::put('/adminpanel/editpost',
                ['as' => 'edit_post_action', 'uses' => 'Admin\AdminPostController@edit_post']);
            Route::post('/adminpanel/addnewpost',
                ['as' => 'create_post_action', 'uses' => 'Admin\AdminPostController@add_new_post']);
            /*
             * Удаляем навсегда
             */
            Route::delete('/adminpanel/delpost/{post_id}',
                ['as' => 'delete_post', 'uses' => 'Admin\AdminPostController@del_post']);
            Route::delete('/adminpanel/delchosepost',
                ['as' => 'delete_chose_post', 'uses' => 'Admin\AdminPostController@del_chose_post']);
            /*
             * Помещаем в корзину
             */
            Route::delete('/adminpanel/posttotrash/{post_id}',
                ['as' => 'to_trash_post', 'uses' => 'Admin\AdminPostController@moveToTrash']);
            Route::delete('/adminpanel/choseposttotrash',
                ['as' => 'to_trash_chose_post', 'uses' => 'Admin\AdminPostController@moveToTrashChosen']);
            /*
             * Восстанавливаем статью из корзины
             */
            Route::post('/adminpanel/restorepost/{post_id}',
                ['as' => 'restore_post', 'uses' => 'Admin\AdminPostController@restorePost']);
    }

    public function url(){
        if($this->main_cat != 0){
            $cat = Category::findOrFail($this->main_cat);
            return route('single_blog_page_with_cat', array('category_slug'=>$cat->cat_slug, 'post_slug'=>$this->post_slug));
        }
        else{
            return route('single_blog_page', array('post_slug'=>$this->post_slug));
        }
    }

}
