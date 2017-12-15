<?php

namespace App\Http\Controllers;

use App\Media;
use App\Page;
use App\WP\WPImporter;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use SimpleXMLElement;

class AdminPanelController extends Controller
{
    /**
     * Вызов главной странице
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $post_count = Post::where('post_status','<>','trash')->get()->count();
        $page_count = Page::where('page_status','<>','trash')->get()->count();
        $cat_count = Category::where('cat_status','<>','trash')->get()->count();
        $media_count = count(Media::all());
        return view('adminpanel.index')->withPost($post_count)->withCat($cat_count)->withPage($page_count)->withMedia($media_count);        
    }
    public function wp_load_xml(Request $request){

        $this->validate($request, [
            'wpxml' => 'required|mimes:xml'
        ]);

        $file = $request->file('wpxml');

        $res = WPImporter::loadFromForm($file)->import();
        return redirect('/adminpanel/wpimporter/')->withData($res);
    }

    public function wp_do_xml(Request $request){
        $this->validate($request, [
            'wpxml' => 'required'
        ]);

        $file = $request->wpxml;
dd($file);
        $res = WPImporter::loadFromText($file)->import();
        return redirect('/adminpanel/wpimporter/')->withData($res);
    }
    public function wp_do_ajax_xml(Request $request){
        $this->validate($request, [
            'wpxml' => 'required'
        ]);

        $file = $request->wpxml;
        
        WPImporter::loadFromText($file)->import();
    }
    
    public function wpimporter(){
        if(session('data')){
            return view('adminpanel.wpimporter')->withData(session('data'));
        }
        return view('adminpanel.wpimporter');
    }


}
