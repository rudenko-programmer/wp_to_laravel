<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AdminPageController extends Controller
{
    /**
     * Метод по добавлению новой страници
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_new_page(Request $request){
        $validate = $this->validate($request, [
            'page_title' => 'required|min:3|max:255',
            'page_slug' => 'required|unique:pages|min:3|max:255|alpha_dash',
            'page_status' => 'required'
        ]);
        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }

        $page = Page::create([
            'page_title' => $request->page_title,
            'page_slug' => $request->page_slug,
            'page_content' => isset($request->page_content)?$request->page_content:'',
            'page_thumbnail' => isset($request->page_thumbnail)?$request->page_thumbnail:'',
            'page_status' => $request->page_status,
            'hash_url' => sha1($request->page_title),
            'page_author' => $request->user()->user_id,
            'meta_description' => isset($request->meta_description)?$request->meta_description:'',
            'meta_keywords' => isset($request->meta_keywords)?$request->meta_keywords:'',
        ]);

        return redirect('/adminpanel/page/'.$page->page_id)->with('code', 1);
    }

    /**
     * Метод редактирования страници
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit_page(Request $request){
        $validate = $this->validate($request, [
            'page_title' => 'required|min:3|max:255',
            'page_slug' => Rule::unique('pages')->ignore($request->page_id, 'page_id'),
            'page_status' => 'required'
        ]);

        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }
        $page = Page::findOrFail($request->page_id);

        if(!$page){abort(404);}

        $page->page_title = $request->page_title;
        $page->page_slug = $request->page_slug;
        $page->page_content = isset($request->page_content)?$request->page_content:'';
        $page->page_thumbnail = isset($request->page_thumbnail)?$request->page_thumbnail:'';
        $page->page_status = $request->page_status;
//        $page->hash_url = isset($request->hash_url)?$request->hash_url:'';
        $page->meta_description = isset($request->meta_description)?$request->meta_description:'';
        $page->meta_keywords = isset($request->meta_keywords)?$request->meta_keywords:'';
        $page->save();

        $requestcode = '1';

        return redirect('/adminpanel/page/'.$page->page_id)->with('code', $requestcode);
    }

    /**
     * Метод вывод страницы новая статья
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new_page(){
        return view('adminpanel.pages.newpage');
    }


    /**
     * Метод вывод страницы все страници
     * @return mixed
     */
    public function all_pages(){
        $pages = Page::where('page_status','<>','trash')
                ->orderBy('page_id','desc')
                ->get();
        return view('adminpanel.pages.allpage')->withPages($pages);
    }
    /**
     * Метод вывод страницы корзины страниц
     * @return mixed
     */
    public function all_trash_pages(){
        $posts = Page::where('page_status','=','trash')
            ->orderBy('page_id','desc')
            ->get();
        return view('adminpanel.pages.trashpage')->withPages($posts);
    }

    /**
     * Метод вывода страници по page_id для редактирования
     * @param $id
     * @return mixed
     */
    public function get_page($id){
        $page = Page::findOrFail($id);

        if(!$page){abort(404);}
        $code = session('code')?session('code'):"0";

        return view('adminpanel.pages.editpage')
            ->withPage($page)
            ->withCode($code);
    }

    /**
     * Метод удаления страници по page_id
     * @param $page_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_page($page_id)
    {
        $blog = Page::find($page_id);
        $blog->delete();
        return redirect('/adminpanel/trashpages');
    }

    public function del_chose_page(Request $request)
    {
        $validate = $this->validate($request, [
            'page' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->page)){
            foreach ($request->page as $page_id){
                $page = Page::findOrFail($page_id);
                $page->delete();
            }
        }
        return redirect('/adminpanel/trashpages');
    }
    public function moveToTrash($page_id)
    {
        Page::findOrFail($page_id)->toTrash();
        return redirect('/adminpanel/allpages');
    }


    public function moveToTrashChosen(Request $request)
    {
        $validate = $this->validate($request, [
            'page' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->page)){
            foreach ($request->page as $page_id){
                Page::findOrFail($page_id)->toTrash();
            }
        }
        return redirect()->back();
    }

    public function restorePage($id){
        Page::findOrFail($id)->restore();
        return redirect()->back();
    }
}
