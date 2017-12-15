<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function blogPage(){
        $posts = Post::where(array(
                    array('post_status','<>','draft'),
                    array('post_status','<>','trash'),
                ))
                ->orderBy('created_at','desc')
                ->paginate(env('POSTS_PER_PAGE'));
        return view('blog.blog')->withPosts($posts);
    }
    public function vueBlogPage(){
        $posts = Post::where(array(
            array('post_status','<>','draft'),
            array('post_status','<>','trash'),
        ))
            ->orderBy('created_at','desc')
            ->get();
        return view('blog.vueblog')->withPosts($posts);
    }
    public function singleBlogPage($post_slug){
        $post = Post::where('post_slug',strtolower(urlencode($post_slug)))->firstOrFail();
        return view('blog.single')->withPost($post);
    }
    public function singleBlogPageWithCat($category_slug, $post_slug){
        $post = Post::where('post_slug',strtolower(urlencode($post_slug)))->firstOrFail();
        return view('blog.single')->withPost($post);
    }
    public function ampSingleBlogPage($post_slug){
        $post = Post::where('post_slug',strtolower(urlencode($post_slug)))->firstOrFail();
        return view('blog.amp_single')->withPost($post);
    }

    public function apiGetPosts(){
        $posts = Post::where(array(
            array('post_status','<>','draft'),
            array('post_status','<>','trash'),
        ))
            ->orderBy('created_at','desc')
            ->get();

        $get_posts = array();

        foreach ($posts as $post){
            $_post = new \stdClass();
            $_post->id        = $post->post_id;
            $_post->title     = $post->post_title;
            $_post->except    = $post->excerpt();
            $_post->thumbnail = url($post->thumbnail());
            $_post->date      = $post->created_at->format('Y/m/d');
            $_post->author    = $post->author->first_name;
            $_post->id = $post->post_id;
            $_post->id = $post->post_id;

            $_post->tags = array();

            foreach($post->tags as $tag):
                $_tag =  new \stdClass();
                $_tag->url      = route('tag_page',['tag_slug'=>$tag->tag_slug]);
                $_tag->title    = $tag->tag_title;
                $_post->tags[] = $_tag;
            endforeach;
            $get_posts[] = $_post;
        }


        return $get_posts;
    }
}
