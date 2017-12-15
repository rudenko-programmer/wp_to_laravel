<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function tagPage($tag_slug){

        $tag = Tag::where('tag_slug',strtolower(urlencode($tag_slug)))->firstOrFail();
        $posts = $tag->posts()->paginate(env('POSTS_PER_PAGE'));

        return view('blog.tag')
            ->withTag($tag)
            ->withPosts($posts);
    }
}
