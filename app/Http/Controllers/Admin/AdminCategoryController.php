<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{

    /** Метод вывода всех категорий
     * @return mixed
     */
    public function all_cat(){
        $categories = Category::get_categories_children(0,array(array('rule'=>'<>','value'=>'trash')));
        return view('adminpanel.categories.allcat')->withCategories($categories);
    }
    /** Метод вывода корзины категорий
     * @return mixed
     */
    public function all_trash_cat(){
        $categories = Category::get_categories_children(0,array(array('rule'=>'=','value'=>'trash')));
        return view('adminpanel.categories.trashcat')->withCategories($categories);
    }

    /**
     * Метод вывода страницы новая категория
     * @return mixed
     */
    public function new_cat(){
        $categories = Category::get_categories_children(0);
        return view('adminpanel.categories.newcat')->withCategories($categories);
    }

    /**
     * Метод добавления новой категории
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add_new_cat(Request $request){
        $validate = $this->validate($request, [
            'cat_title' => 'required|min:3|max:255',
            'cat_slug' => 'required|unique:categories|min:3|max:255|alpha_dash',
            'cat_status' => 'required'
        ]);
        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }

        $cat = Category::create([
            'cat_title' => $request->cat_title,
            'cat_slug' => $request->cat_slug,
            'parent_id'=> $request->parent_id,
            'cat_content' => isset($request->cat_content)?$request->cat_content:'',
            'cat_thumbnail' => isset($request->cat_thumbnail)?$request->cat_thumbnail:'',
            'cat_status' => $request->cat_status,
            'hash_url' => sha1($request->cat_slug),
            'meta_description' => isset($request->meta_description)?$request->meta_description:'',
            'meta_keywords' => isset($request->meta_keywords)?$request->meta_keywords:'',
        ]);
        return redirect('/adminpanel/cat/'.$cat->cat_id)->with('code', 1);
    }

    /**
     * Метод редактирования новой категории
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit_cat(Request $request){

        $validate = $this->validate($request, [
            'cat_title' => 'required|min:3|max:255',
            'cat_slug' => Rule::unique('categories')->ignore($request->cat_id, 'cat_id'),
            'cat_status' => 'required'
        ]);
        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }
        $cat = Category::findOrFail($request->cat_id);

        if(!$cat){abort(404);}


        $cat->cat_title = $request->cat_title;
        $cat->cat_slug = $request->cat_slug;

        /**
         * Проверяем если у категории есть дочерние елементы и мы его перемещаем,
         * тогда передаём дочерним елементам его parent_id, а саму категорию благополучно перемещаем
         */
        if($cat->parent_id != $request->parent_id){
            foreach ($cat->children()->get() as $child){
                $child->parent_id = $cat->parent_id;
                $child->save();
            }
        }
        $cat->parent_id =  $request->parent_id;


        $cat->cat_content = isset($request->cat_content)?$request->cat_content:'';
        $cat->cat_thumbnail = isset($request->cat_thumbnail)?$request->cat_thumbnail:'';
        $cat->cat_status = $request->cat_status;
//        $cat->hash_url = sha1($request->cat_title);
        $cat->meta_description = isset($request->meta_description)?$request->meta_description:'';
        $cat->meta_keywords = isset($request->meta_keywords)?$request->meta_keywords:'';
        $cat->save();

        $requestcode = '1';

        return redirect('/adminpanel/cat/'.$cat->cat_id)->with('code', $requestcode);
    }

    /**
     * Метод вывода категории по cat_id
     * @param $id
     * @return mixed
     */
    public function get_cat($id){
        $cat = Category::findOrFail($id);

        if(!$cat){abort(404);}
        $code = session('code')?session('code'):"0";

        $categories = Category::get_categories_children(0);

        return view('adminpanel.categories.editcat')->withCat($cat)->withCategories($categories)->withCode($code);
    }

    /**
     * Метод удаления категории по cat_id
     * @param $cat_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_cat($cat_id)
    {
        $cat = Category::findOrFail($cat_id);
        $cat->delete();
        return redirect('/adminpanel/trashcat');
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_chose_cat(Request $request)
    {
        $validate = $this->validate($request, [
            'cat' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->cat)){
            foreach ($request->cat as $cat_id){
                $cat = Category::findOrFail($cat_id);
                $cat->delete();
            }
        }
        return redirect('/adminpanel/trashcat');
    }
    public function moveToTrash($cat_id)
    {
        Category::findOrFail($cat_id)->toTrash();
        return redirect('/adminpanel/allcat');
    }


    public function moveToTrashChosen(Request $request)
    {
        $validate = $this->validate($request, [
            'cat' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->cat)){
            foreach ($request->cat as $cat_id){
                Category::findOrFail($cat_id)->toTrash();
            }
        }
        return redirect()->back();
    }

    public function restoreCategory($id){
        Category::findOrFail($id)->restore();
        return redirect()->back();
    }
}
