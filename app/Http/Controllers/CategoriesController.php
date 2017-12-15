<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categoryPage($cat_slug){

        $category = Category::where('cat_slug',strtolower(urlencode($cat_slug)))->firstOrFail();
        $posts = $category->posts()->paginate(env('POSTS_PER_PAGE'));;


        return view('blog.category')
                ->withCategory($category)
                ->withPosts($posts);
    }
}
