<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function mainPage(){
        return view('blog.main');
    }

    public function singlePage($page_slug){
        $page = Page::where('page_slug',$page_slug)->firstOrFail();
        return view('blog.page')->withPage($page);
    }
}
