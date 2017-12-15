<?php

namespace App\Http\Controllers\Admin;

use App\Media;
use App\Post;
use App\Page;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMediaController extends Controller
{
    /**
     * Метод выводит главную страницу медиафайлов
     * @return mixed
     */
    public function media(){
        $media = Media::orderBy('created_at','desc')->get();
        return view('adminpanel.mediafile')->withMedia($media);
    }

    /**
     * Метод загружает полученые картинки на сервер
     * @param Request $request
     * @return Media
     */
    public function addPhoto(Request $request){
        $this->validate($request, [
            'photo' => 'required|mimes:jpeg,jpg,png,bmp,gif'
        ]);
        $file = $request->file('photo');
        return Media::uploadPhotosFromForm($file);
    }


    /**
     * Метод удаляет фото
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        $media = Media::findOrFail($id);
        $media->delete();
        return back();
    }

    public function viewAddPhotoTo($type, $id){
        if($type === 'post' || $type === 'page' || $type === 'category'){
            $media = Media::orderBy('created_at','desc')->get();
            return view('adminpanel.media.addphoto')->withType($type)->withId($id)->withMedia($media);
        }
        return back();
    }
    
    public function addPhotoTo($type, $id, Request $request){

        $this->validate($request, [
            'media_id' => 'required'
        ]);

        $photo = Media::findOrFail($request->media_id);

        if($type === 'post'){
            Post::addPhoto($id, $photo->name);
            return redirect('/adminpanel/post/'.$id);
        }
        if($type === 'page'){
            Page::addPhoto($id, $photo->name);
            return redirect('/adminpanel/page/'.$id);
        }
        if($type === 'category'){
            Category::addPhoto($id, $photo->name);
            return redirect('/adminpanel/cat/'.$id);
        }

        return back();
    }
    
    public function apiGetImages(){
        $medias = Media::orderBy('created_at','desc')->get();

        $_media = array();

        foreach ($medias as $image) {
            $_image = new \stdClass();
            $_image->id = $image->id;
            $_image->name = $image->name;
            $_image->full = url($image->getFullImg());
            $_image->thumb = url($image->getThumbnail());
            $_media[] = $_image;
        }
        return $_media;
    }
    
    public function apiGetUploadImages($id){

        $image = Media::findOrFail((string)$id);

        $_image = new \stdClass();
        $_image->id = $image->id;
        $_image->full = url($image->getFullImg());
        $_image->thumb = url($image->getThumbnail());
        
        return [$_image];

    }

    public function apiDeleteImages($id){
        $image = Media::findOrFail((string)$id);
        $image->delete();
    }
}
