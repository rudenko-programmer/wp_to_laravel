<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'second_name', 'third_name', 'email', 'password', 'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Метод создаёт отношение One{пользователь} to Many{Статей}
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('App/Post', 'post_author', 'user_id');
    }

    /**
     * Метод создаёт отношение One{пользователь} to Many{Страниц}
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('App/Page', 'page_author', 'user_id');
    }

    /**
     * Метод создаёт отношение One{пользователь} to Many{Комментариев}
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App/Comment', 'comment_author', 'user_id');
    }

    /**
     * Метод выводит миниатюру
     * @return string
     */
    public function thumbnail(){
        return Media::getImg($this->user_thumbnail,'thumbnail');
    }

    /**
     * Метод выводить полную картинку
     * @return string
     */
    public function img(){
        return Media::getImg($this->user_thumbnail,'full');
    }

    /**
     * Метод добавляет картинку к посту
     * @param $id
     * @param $value
     */
    static function addPhoto($id, $value){
        $user = User::findOrFail($id);
        $user->user_thumbnail = $value;
        $user->save();
    }

    public function isAdmin(){
        if($this->role === 'admin') return true;
        return false;
    }

    public function hasRole($roles){
        if(is_array($roles) && count($roles) && in_array($this->role, $roles))
            return true;
        return false;
    }

    public function fullName(){
        return $this->second_name." ".$this->first_name." ".$this->third_name;
    }
}
