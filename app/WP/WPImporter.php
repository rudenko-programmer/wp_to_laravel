<?php

namespace App\WP;

use App\Category;
use App\Media;
use App\Page;
use App\Post;
use App\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use phpDocumentor\Reflection\Types\This;
use SimpleXMLElement;
use Validator;

class WPImporter extends Model
{

    private $XML;
    /**
     * WPImporter constructor.
     */
    public function __construct($xml_data)
    {        
        $this->XML = $this->validateWPXML($xml_data);
    }

    /**
     * Метод валидации текста под нужды WordPress
     * @param $xml
     * @return mixed
     */
    public function validateWPXML($xml){
        $xml = str_replace("<wp:", '<wp_', $xml);
        $xml = str_replace("</wp:", '</wp_', $xml);
        $xml = str_replace("<content:encoded>", '<content_encoded>', $xml);
        $xml = str_replace("</content:encoded>", '</content_encoded>', $xml);
        return $xml;
    }

    public function import(){
        set_time_limit(1000);

        $import_results = array(
            'post' => 0,
            'page' => 0,
            'category' => 0,
            'attachment' => 0,
        );

        $import_xml = new SimpleXMLElement($this->getXML());
        $items = $import_xml->channel->item;

        $wp_category = $import_xml->channel->wp_category;

        /*
         * Массив категорий хранит данные name => cat_id
         * Для установки родительских категорий
         */

        $categories_array = array();

        foreach ($wp_category as $category){
            $categories_array = $this->importCategories($category, $categories_array);
        }

        $wp_tag = $import_xml->channel->wp_tag;

        /*
         * Массив меток хранит данные name => tag_id
         * Для установки родительских категорий
         */

        $tags_array = array();

        foreach ($wp_tag as $tag){
            $tags_array = $this->importTags($tag, $tags_array);
        }

        /*
         * Масив хранит в себе данные о изображениях в формате id => name
         * Для облегчения добавления картинок к записям
         */
        $attachment_array = array();

        foreach ($items as $item){
            switch ((string)$item->wp_post_type){
                case 'attachment':
//                    $attachment_array = $this->importAttachment($item, $attachment_array);
                    $import_results['attachment'] ++;
                    break;
                case 'post':
                    $this->importPosts($item, $attachment_array, $categories_array, $tags_array);
                    $import_results['post'] ++;
                    break;
                case 'page':
                    $this->importPages($item, $attachment_array);
                    $import_results['page'] ++;
                    break;
            }
        }
        
//        echo json_encode($attachment_array);
        
        return $import_results;
    }
    
    private function importPosts(SimpleXMLElement $item, $attachment_array = array(), $categories_array = array(), $tags_array = array()){
        $post = new Post();

        $validate = Validator::make($this->xml2array($item), [
            'title' => 'required|min:3|max:255',
            'wp_post_name' => 'required|unique:posts,post_slug|min:3|max:255',
            'wp_status' => 'required',
            'wp_post_date_gmt' => 'required|date|date_format:"Y-m-d G:i:s',
        ]);

        if ($validate->fails()) return 0;
        
        $post->post_title = (string)$item->title;
        $post->post_slug  = urldecode((string)$item->wp_post_name);
        $post->post_content = (string)$item->content_encoded;
        $post->setCreatedAt((string)$item->wp_post_date_gmt);
        $post->setUpdatedAt((string)$item->wp_post_date_gmt);
        
        $post->setStatus($item->wp_status);

        /*
         * TODO Автоматическое заполнение метатегов при необходимости
         */
        $post->meta_description = '';
        $post->meta_keywords = '';

        $post->hash_url = sha1((string)$post->post_slug);

        /*
         * TODO заменить автора на реального
         */
        $post->post_author = 1;

        /*
         * Пробегаемся по метаданным и ищем миниатюру
         */
        if(count($item->wp_postmeta)){
            foreach ($item->wp_postmeta as $meta){
                if((string)$meta->wp_meta_key === '_thumbnail_id'
                    && isset($attachment_array[(string)$meta->wp_meta_value])){
                    $post->post_thumbnail = $attachment_array[(string)$meta->wp_meta_value];
                }
            }
        }
        $post->save();
        /*
        * Добавляем категории к записям. После сохранения для того чтобы получить post_id
        */
        if(count($item->category)){
            foreach ($item->category as $meta){
                if((string)$meta->attributes()->domain === 'category'
                    && isset($categories_array[(string)$meta->attributes()->nicename]))
                {
                    $post->categories()->attach($categories_array[(string)$meta->attributes()->nicename]);
                }
                if((string)$meta->attributes()->domain === 'post_tag'
                    && isset($tags_array[(string)$meta->attributes()->nicename]))
                {
                    $post->tags()->attach($tags_array[(string)$meta->attributes()->nicename]);
                }
            }
            if(count($post->categories)){
                $post->main_cat = $post->categories[0]->cat_id;
            }
        }

        $post->save();
    }
    
    private function importPages(SimpleXMLElement $item, $attachment_array = array()){
        $page = new Page();

        $validate = Validator::make($this->xml2array($item), [
            'title' => 'required|min:3|max:255',
            'wp_post_name' => 'required|unique:pages,page_slug|min:3|max:255',
            'wp_status' => 'required',
            'wp_post_date_gmt' => 'required|date|date_format:"Y-m-d G:i:s',
        ]);

        if ($validate->fails()) return 0;

        $page->page_title = (string)$item->title;
        $page->page_slug  = urldecode((string)$item->wp_post_name);
        $page->page_content = (string)$item->content_encoded;
        $page->setCreatedAt((string)$item->wp_post_date_gmt);
        $page->setUpdatedAt((string)$item->wp_post_date_gmt);
        
        $page->setStatus($item->wp_status);

        /*
         * TODO Автоматическое заполнение метатегов при необходимости
         */
        $page->meta_description = '';
        $page->meta_keywords = '';

        /*
         * TODO Хеш Урл страницы отображается случайно
         */
        $page->hash_url = sha1((string)$page->page_slug);

        /*
         * TODO заменить автора на реального
         */
        $page->page_author = 1;

        /*
         * Пробегаемся по метаданным и ищем миниатюру
         */
        if(count($item->wp_postmeta)){
            foreach ($item->wp_postmeta as $meta){
                if((string)$meta->wp_meta_key === '_thumbnail_id'
                    && isset($attachment_array[(string)$meta->wp_meta_value])){
                    $page->page_thumbnail = $attachment_array[(string)$meta->wp_meta_value];
                }
            }
        }


        $page->save();
    }

    private function importAttachment(SimpleXMLElement $item, $attachment_array = array()){
        $url = (string)$item->wp_attachment_url;
        $name = time().basename($url);
        if(!preg_match("/^[\.\-\w]*[.][jpeg|jpg|png|gif|bmp]{3,4}$/u",$name)) return $attachment_array;
        $name = self::translitarate($name);
        $attachment_array[(int)$item->wp_post_id] =  $name;
        return $attachment_array;
    }
    private function importAttachmentOld(SimpleXMLElement $item, $attachment_array = array()){

        $url = (string)$item->wp_attachment_url;

        $name = time().basename($url);

        if(!preg_match("/^[\.\-\w]*[.][jpeg|jpg|png|gif|bmp]{3,4}$/u",$name)) return $attachment_array;

        $name = self::translitarate($name);

        if(copy($url, Media::getFullName($name))){
            $attachment = new Media();
            $attachment->name = $name;
            $attachment->createThumbnail($name);
            $attachment->save();

            $attachment_array[(int)$item->wp_post_id] =  $name;
        }

        return $attachment_array;
        
    }

    private function importCategories(SimpleXMLElement $item, $categories_array = array())
    {
        $validate = Validator::make($this->xml2array($item), [
            'wp_cat_name' => 'required|min:3|max:255',
            'wp_category_nicename' => 'required|unique:categories,cat_slug|min:3|max:255',
        ]);


        if ($validate->fails()) return 0;

        $category = new Category();
        $category->cat_title = (string)$item->wp_cat_name;
        $category->cat_slug = urldecode((string)$item->wp_category_nicename);

        /*
         * TODO Хеш Урл в категории отображается случайно
         */
        $category->hash_url = sha1((string)$category->cat_slug);

        /*
         * Проверяем существует ли родительская категория для этой категории
         */
        if ((string)$item->wp_category_parent != '' && isset($categories_array[(string)$item->wp_category_parent])) {
            $category->parent_id = $categories_array[(string)$item->wp_category_parent];
        }
        else{
            $category->parent_id = 0;
        }


        $category->cat_status = 'publish';
        $category->cat_content = "";
        $category->meta_description = '';
        $category->meta_keywords = '';

        $category->save();

        /* Сохраняем категорию в общий масив */
        $categories_array[(string)$item->wp_category_nicename] = $category->cat_id;

        return $categories_array;
    }

    private function importTags(SimpleXMLElement $item, $tags_array = array())
    {
        $validate = Validator::make($this->xml2array($item), [
            'wp_tag_name' => 'required|min:3|max:255',
            'wp_tag_slug' => 'required|unique:tags,tag_slug|min:3|max:255',
        ]);


        if ($validate->fails()) return 0;

        $tag = new Tag();
        $tag->tag_title = (string)$item->wp_tag_name;
        $tag->tag_slug = urldecode((string)$item->wp_tag_slug);

        /*
         * TODO Хеш Урл в метку отображается случайно
         */
        $tag->hash_url = sha1((string)$tag->tag_slug);

        $tag->save();

        /* Сохраняем метку в общий масив */
        $tags_array[(string)$item->wp_tag_slug] = $tag->tag_id;

        return $tags_array;
    }
    /**
     * Метод загружает переданый файл из формы и возвращает объект класа WPImport
     * @param UploadedFile $file
     * @return static
     */
    static function loadFromForm(UploadedFile $file){
        $xml = file_get_contents($file->getRealPath());
        return new static($xml);
    }

    static function loadFromText($text){
        return new static($text);
    }

    /**
     * @return array
     */
    public function getXML()
    {
        return $this->XML;
    }

    static function translitarate($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        $s = str_replace("?", "", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = is_array($node)? '':(string)$node;

        return $out;
    }
}
