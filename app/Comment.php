<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $guarded = [];

    public function posts(){
        return $this->belongsTo('App\Post', 'comment_post', 'post_id');
    }
    public function author(){
        return $this->belongsTo('App\User', 'comment_author', 'user_id');
    }

}
