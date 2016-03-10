<?php

namespace App;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddPhotoToFlyer
{
    protected $flyer;
    protected $file;

    public function __construct(Flyer $flyer,UploadedFile $file, Thumbnail $thumbnail=null)
    {
        $this->flyer = $flyer;
        $this->file = $file;
        $this->thumbnail = $thumbnail ?:new Thumbnail;
    }

    public function save()
    {
        //Attach the photo to the flyer
        $photo = $this->flyer->addPhoto($this->makePhoto());

        //move the photo to images folder
        $this->file->move($photo->baseDir(), $photo->name);

        //generate a thumbnail
        $this->thumbnail->make($photo->path, $photo->thumbnail_path);
    }

    /**
     * Make a new photo instance.
     * @return Photo
     */
    protected function makePhoto()
    {
        return new Photo(['name' => $this->makeFileName()]);
    }

    /**
     * Make a file name, based on the uploaded file.
     * @return string
     */
    protected function makeFileName(){
        $name = sha1(
            time().$this->file->getClientOriginalName()//time()+foo.jpg
        );

        $extension = $this->file->getClientOriginalExtension();//jpg,上传文件后缀名

        return"{$name}.{$extension}";
    }
}