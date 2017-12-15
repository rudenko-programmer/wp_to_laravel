<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

use Intervention\Image\ImageManagerStatic as Image;

class Media extends Model
{
    protected  $table = "media";

    protected $fillable = ['path'];

    const basePhotoDir = "mediacontent/photos";
    const basePhotoThumbnailDir = "mediacontent/photos/thumbnail";
    const thumbnail_prefix = 'thumb-';


    public static function uploadPhotosFromURL($img_url){

    }

    /**
     * Метод загружает фото с формы
     * @param UploadedFile $file
     * @return Media
     */
    public static function uploadPhotosFromForm(UploadedFile $file){
        $photo = new self;
        $photo->savePhoto($file);
        return $photo;
    }


    /**
     * Метод сохраняет файлы картинок
     * @param UploadedFile $file
     */
    public function savePhoto(UploadedFile $file){
        
        $name = time().$file->getClientOriginalName();

        $file->move(self::basePhotoDir, $name);

        $this->createThumbnail($name);

        $this->name = $name;

        $this->save();
    }

    /**
     * Создаёт миниатюру
     * @param $name
     */
    public function createThumbnail($name){
        Image::make(self::getFullName($name))
            ->fit(200)
            ->save(self::getThumbnailName($name));
    }

    /**
     * Метод получает полное имя фото
     * @param $name
     * @return string
     */
    static function getFullName($name){
        return self::basePhotoDir."/".$name;
    }

    /**
     * Метод для получения имя миниатюры
     * @param $name
     * @return string
     */
    public static function getThumbnailName($name){
        return self::basePhotoThumbnailDir."/".self::thumbnail_prefix.$name;
    }

    public function getFullImg(){
        return self::getImg($this->name, 'full');
    }

    public function getThumbnail(){
        return self::getImg($this->name, 'thumbnail');
    }

    static function getImg($name, $size = 'thumbnail'){
        switch ($size){
            case 'thumbnail': return self::getThumbnailName($name);
            default: return self::getFullName($name);
        }
    }

    function delete(){
        //TODO Добавить удаление во всех местах
        \File::delete([
            $this->getFullImg(),
            $this->getThumbnail()
        ]);
        parent::delete();
    }
}
