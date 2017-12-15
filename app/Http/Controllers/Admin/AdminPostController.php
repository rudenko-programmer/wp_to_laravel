<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    /**
     * Метод по добавлению новой статьи
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_new_post(Request $request){
        $validate = $this->validate($request, [
            'post_title' => 'required|min:3|max:255',
            'post_slug' => 'required|unique:posts|min:3|max:255|alpha_dash',
            'post_status' => 'required'
        ]);
        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }

        $post = Post::create([
            'post_title' => $request->post_title,
            'post_slug' => $request->post_slug,
            'post_content' => isset($request->post_content)?$request->post_content:'',
            'post_thumbnail' => isset($request->post_thumbnail)?$request->post_thumbnail:'',
            'post_status' => $request->post_status,
            'hash_url' => sha1($request->post_slug),
            'post_author' => $request->user()->user_id,
            'meta_description' => isset($request->meta_description)?$request->meta_description:'',
            'meta_keywords' => isset($request->meta_keywords)?$request->meta_keywords:'',
        ]);
        if(isset($request->post_tags) && is_array($request->post_tags)
            && count($request->post_tags))
        {
            $post->tags()->detach();
            $post->tags()->attach($request->post_tags);
        }
        else{
            $post->tags()->detach();
        }
        if(isset($request->post_categories) && is_array($request->post_categories)
            && count($request->post_categories))
        {
            $post->categories()->detach();
            $post->categories()->attach($request->post_categories);
        }
        else{
            $post->categories()->detach();
        }
        $post->main_cat = isset($request->main_cat)?$request->main_cat:count($post->categories)?$post->categories[0]->cat_id:0;
        $post->save();

        return redirect('/adminpanel/post/'.$post->post_id)->with('code', 1);
    }

    /**
     * Метод редактирования статьи
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit_post(Request $request){
        $validate = $this->validate($request, [
            'post_title' => 'required|min:3|max:255',
            'post_slug' => Rule::unique('posts')->ignore($request->post_id, 'post_id'),
            'post_status' => 'required'
        ]);

        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }
        $post = Post::findOrFail($request->post_id);

        if(!$post){abort(404);}


        if(isset($request->post_categories) && is_array($request->post_categories)
            && count($request->post_categories))
        {
            /*
             * TODO проверить правильное применение atach() detach() чтобы каждый раз не тратилось время на перезапись
             */
            $post->categories()->detach();
            $post->categories()->attach($request->post_categories);
        }
        else{
            $post->categories()->detach();
        }

        if(isset($request->post_tags) && is_array($request->post_tags)
            && count($request->post_tags))
        {
            $post->tags()->detach();
            $post->tags()->attach($request->post_tags);
        }
        else{
            $post->tags()->detach();
        }

        $post->post_title = $request->post_title;
        $post->post_slug = $request->post_slug;
        $post->post_content = isset($request->post_content)?$request->post_content:'';
        $post->post_thumbnail = isset($request->post_thumbnail)?$request->post_thumbnail:'';
        $post->post_status = $request->post_status;
        $post->meta_description = isset($request->meta_description)?$request->meta_description:'';
        $post->meta_keywords = isset($request->meta_keywords)?$request->meta_keywords:'';
        $post->main_cat = isset($request->main_cat)?$request->main_cat:count($post->categories)?$post->categories[0]->cat_id:0;
        $post->save();

        $requestcode = '1';

        return redirect('/adminpanel/post/'.$post->post_id)->with('code', $requestcode);
    }

    /**
     * Метод вывод страницы новая статья
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new_post(){
        $categories = Category::get_categories_children(0);
        $tags = Tag::orderBy('tag_id','desc')
            ->get();
        return view('adminpanel.posts.newpost')
            ->withCategories($categories)->withTags($tags);
    }


    /**
     * Метод вывод страницы все статьи
     * @return mixed
     */
    public function all_posts(){
        $posts = Post::where('post_status','<>','trash')
                     ->orderBy('post_id','desc')
                     ->get();
        return view('adminpanel.posts.allpost')->withPosts($posts);
    }
    /**
     * Метод вывод страницы корзины статей статьи
     * @return mixed
     */
    public function all_trash_posts(){
        $posts = Post::where('post_status','=','trash')
                     ->orderBy('post_id','desc')
                     ->get();
        return view('adminpanel.posts.trashpost')->withPosts($posts);
    }

    /**
     * Метод вывода статьи по post_id для редактирования
     * @param $id
     * @return mixed
     */
    public function get_post($id){
        $post = Post::findOrFail($id);

        $categories = Category::get_categories_children(0);

        $tags = Tag::orderBy('tag_id','desc')
            ->get();

        if(!$post){abort(404);}
        $code = session('code')?session('code'):"0";
        /**
         * Массив выбраных cat_id поста
         */
        $cat_array = array();
        //$post->categories => $post->categories()->get()
        foreach ($post->categories as $cat){
            $cat_array[] = $cat->cat_id;
        }
        /**
         * Массив выбраных tag_id поста
         */
        $tag_array = array();
        foreach ($post->tags as $tag){
            $tag_array[] = $tag->tag_id;
        }

        return view('adminpanel.posts.editpost')
            ->withPost($post)
            ->withCategories($categories)
            ->withTags($tags)
            ->withSelectcategories($cat_array)
            ->withSelecttags($tag_array)
            ->withCode($code);
    }

    /**
     * Метод удаления статьи по post_id
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_post($post_id)
    {
        $blog = Post::find($post_id);
        $blog->delete();
        return redirect('/adminpanel/trashposts');
    }


    public function del_chose_post(Request $request)
    {
        $validate = $this->validate($request, [
            'post' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->post)){
            foreach ($request->post as $post_id){
                $post = Post::findOrFail($post_id);
                $post->delete();
            }
        }
        return redirect('/adminpanel/trashposts');
    }

    public function moveToTrash($post_id)
    {
        Post::findOrFail($post_id)->toTrash();
        return redirect('/adminpanel/allposts');
    }


    public function moveToTrashChosen(Request $request)
    {
        $validate = $this->validate($request, [
            'post' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->post)){
            foreach ($request->post as $post_id){
                Post::findOrFail($post_id)->toTrash();
            }
        }
        return redirect('/adminpanel/allposts');
    }
    
    public function restorePost($id){
        Post::findOrFail($id)->restore();
        return redirect()->back();
    }
}
