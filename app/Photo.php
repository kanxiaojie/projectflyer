<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{
    protected $table = 'flyer_photos';

    /**
     * Fillable fields for a photo.
     * @var array
     */
    protected $fillable = ['path', 'name', 'thumbnail_path'];

    /**
     * A photo belongs to a fly.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flyer()
    {
        return $this->belongsTo('App\Flyer');
    }
//    protected $baseDir = 'images/photos';
//    protected $file;
//
//    protected static function boot(){
//        static::creating(function($photo){
//            return $photo->upload();
//        });
//    }

//    /**
//     * @param UploadedFile $file
//     */
//    public static function fromFile(UploadedFile $file)
//    {
//        $photo = new static;
//
//        $photo->file = $file;
//
//        return $photo->fill([
//            'name' => $photo->fileName(),
//            'path' => $photo->filePath(),
//            'thumbnail_path' => $photo->thumbnailPath()
//        ]);
//    }

//    public function fileName(){
//        $name = sha1(
//            time().$this->file->getClientOriginalName()
//        );
//
//        $extension = $this->file->getClientOriginalExtension();//上传文件后缀名
//
//        return"{$name}.{$extension}";
//    }

    /**
     * @return string
     */
    public function baseDir()
    {
        return "images/photos";
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;

        $this->path = $this->baseDir().'/'.$name;
        $this->thumbnail_path = $this->baseDir().'/tn-'.$name;
    }

    public function delete()
    {
        \File::delete([
            $this->path,
            $this->thumbnail_path
        ]);

        parent::delete();
    }

//    /**
//     * Get the path to the photo.
//     * @return string
//     */
//    public function filePath()
//    {
//        return $this->baseDir().'/'.$this->fileName();
//    }
//
//
//    /**
//     * Get the path to the photo's thumbnail.
//     * @return string
//     */
//    public function thumbnailPath()
//    {
//        return $this->baseDir().'/tn-'.$this->fileName();
//    }


//    /**
//     * Build a new photo instance from a file upload
//     * @param $name
//     * @return static
//     * @internal param UploadedFile $file
//     */
//    public static function named($name)
//    {
//        return (new static)->saveAs($name);
//    }

//    protected function saveAs($name){
//        $this->name = sprintf("%s-%s", time(), $name);
//        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
//        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);
//
//        return $this;
//    }

//    public function upload()
//    {
//
//        $this->makeThumbnail();
//
//        return $this;
//    }

}
