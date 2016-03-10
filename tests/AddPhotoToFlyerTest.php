<?php

namespace App;

use Mockery as m;
use App\Thumbnail;
use App\AddPhotoToFlyer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AddPhotoToFlyerTest extends \TestCase
{
    /**
     * @test
     */
    function it_processes_a_form_to_add_a_photo_to_flyer(){
        $flyer = factory(Flyer::class)->create();

        $file = m::mock(UploadedFile::class, [
            'getClientOriginalName' => 'foo',
            'getClientOriginalExtension' => 'jpg'
        ]);

        $file->shouldReceive('move')
             ->once()
             ->with('images/photos', 'nowfoo.jpg');

        $thumbnail = m::mock(Thumbnail::class);

        $thumbnail->shouldReceive('make')
                  ->once()
                  ->with('images/photos/nowfoo.jpg', 'images/photos/tn-nowfoo.jpg');

        (new AddPhotoToFlyer($flyer, $file, $thumbnail))->save();

        $this->assertCount(1, $flyer->photos);
    }

    function time(){
        return 'now';
    }

    function sha1($path){
        return $path;
    }
}
