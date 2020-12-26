<?php

namespace Tests\Unit;

use App\Helpers\ImageHelper;
use App\Image;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
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
        $this->expectException(InvalidArgumentException::class);
        $fileGIF = UploadedFile::fake()->image('photo.gif');
        $result = ImageHelper::createImageFromFile($fileGIF, 'image/gif');
    }

    /**
     * Test image with specified size is returned from cropImageToCenter function.
     *
     * @return void
     */
    public function testImageWithSpecifiedSizeIsReturnedWhenCropping()
    {
        $fileJPEG = UploadedFile::fake()->image('photo.jpg', 800, 600);
        $image = ImageHelper::createImageFromFile($fileJPEG, 'image/jpeg');

        $result = ImageHelper::cropImageToCenter($image, 200, 200);
        $size = imagesx($result) . "x" . imagesy($result);

        $this->assertIsResource($result);
        $this->assertEquals("200x200", $size);
    }

    /**
     * Test thumbnail resource is created.
     *
     * @return void
     */
    public function testImageThumbnailIsCreated()
    {
        $filePNG = UploadedFile::fake()->image('photo.png');
        $result = ImageHelper::createThumbnailFromImage($filePNG, 200, 200);
        $size = imagesx($result) . "x" . imagesy($result);

        $this->assertIsResource($result);
        $this->assertEquals("200x200", $size);
    }

    /**
     * Test resize to height function.
     *
     * @return void
     */
    public function testResizeToHeight()
    {
        $file = UploadedFile::fake()->image('photo.png', 600, 400);
        $image = imagecreatefrompng($file);
        $result = ImageHelper::resizeToHeight($image, 200);
        $size = imagesx($result) . "x" . imagesy($result);

        $this->assertIsResource($result);
        $this->assertEquals("300x200", $size);
    }

    /**
     * Test resize to width function.
     *
     * @return void
     */
    public function testResizeToWidth()
    {
        $file = UploadedFile::fake()->image('photo.png', 400, 600);
        $image = imagecreatefrompng($file);
        $result = ImageHelper::resizeToWidth($image, 200);
        $size = imagesx($result) . "x" . imagesy($result);

        $this->assertIsResource($result);
        $this->assertEquals("200x300", $size);
    }
}
