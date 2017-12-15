<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminTagController extends Controller
{

    public function all_tags(){
        $tags = Tag::orderBy('tag_id','desc')
            ->paginate(20);
        return view('adminpanel.tag.alltags')->withTags($tags);
    }

    public function create_tag(Request $request){
        $validate = $this->validate($request, [
            'tag_title' => 'required|min:3|max:255',
            'tag_slug' => 'max:255',
        ]);
        if($validate){
            return redirect()->back()->withErrors()->withInput();
        }

        $tag_slug = strlen($request->tag_slug)?self::transliterate($request->tag_slug)
                        :self::transliterate($request->tag_title);

        $post = Tag::create([
            'tag_title' => $request->tag_title,
            'tag_slug' => $tag_slug,
            'hash_url' => sha1($request->tag_slug),
        ]);

        $post->save();
        return redirect('/adminpanel/alltags')->with('code', 1);
    }

    public function del_tag($tag_id)
    {
        $blog = Tag::find($tag_id);
        $blog->delete();
        return redirect('/adminpanel/alltags');
    }


    public function del_chose_tags(Request $request)
    {
        $validate = $this->validate($request, [
            'tag' => 'required'
        ]);
        if($validate){
            return redirect()->back();
        }
        if(count($request->tag)){
            foreach ($request->tag as $tag_id){
                $post = Tag::findOrFail($tag_id);
                $post->delete();
            }
        }
        return redirect('/adminpanel/alltags');
    }

    static function transliterate($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }
}
