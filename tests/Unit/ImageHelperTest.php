<?php

namespace Tests\Unit;

use App\Helpers\ImageHelper;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class ImageHelperTest extends TestCase
{
    /**
     * Test filetype is determined properly.
     *
     * @return void
     */
    public function testFiletypeIsDeterminedProperly(): void
    {
        //JPEG
        $fileJPEG = UploadedFile::fake()->image('photo.jpg');
        $result = ImageHelper::determineImageFiletype($fileJPEG);
        $this->assertEquals("image/jpeg", $result);

        //PNG
        $filePNG = UploadedFile::fake()->image('photo.png');
        $result = ImageHelper::determineImageFiletype($filePNG);
        $this->assertEquals("image/png", $result);
    }

    /**
     * Test GD image is created properly.
     *
     * @return void
     */
    public function testGDImageIsCreatedProperly(): void
    {
        //JPEG
        $fileJPEG = UploadedFile::fake()->image('photo.jpg');
        $result = ImageHelper::createImageFromFile($fileJPEG, 'image/jpeg');
        $this->assertIsResource($result);

        //PNG
        $filePNG = UploadedFile::fake()->image('photo.png');
        $result = ImageHelper::createImageFromFile($filePNG, 'image/png');
        $this->assertIsResource($result);
    }

    /**
     * Test InvalidArgumentException is thrown when filetype is not supported.
     *
     * @return void
     */
    public function  testInvalidArgumentExceptionIsThrownWhenFiletypeIsNotSupported()
    {
        //TODO
    }
}
