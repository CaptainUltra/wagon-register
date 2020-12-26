<?php

namespace Tests\Unit;

use App\Helpers\ImageHelper;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use InvalidArgumentException;
use Tests\TestCase;

class ImageHelperTest extends TestCase
{
    /**
     * Test image with specified size is returned from cropImageToCenter function.
     *
     * @return void
     */
    public function testImageWithSpecifiedSizeIsReturnedWhenCropping()
    {
        $fileJPEG = UploadedFile::fake()->image('photo.jpg', 800, 600);
        $image = ImageManagerStatic::make($fileJPEG);

        $result = ImageHelper::cropImageToCenter($image, 200, 200);
        $size = $result->width() . "x" .$result->height();

        $this->assertInstanceOf(Image::class, $result);
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
        $image = ImageManagerStatic::make($file);
        $result = ImageHelper::resizeToHeight($image, 200);
        $size = $result->width() . "x" .$result->height();

        $this->assertInstanceOf(Image::class, $result);
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
        $image = ImageManagerStatic::make($file);
        $result = ImageHelper::resizeToWidth($image, 200);
        $size = $result->width() . "x" .$result->height();

        $this->assertInstanceOf(Image::class, $result);
        $this->assertEquals("200x300", $size);
    }

    /**
     * Test images are properly saved to storage.
     *
     * @return void
     */
    public function testImagesAreProperlyStored()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('photo.png', 600, 400);
        $image = ImageManagerStatic::make($file);
        ImageHelper::saveImageToStorage($image, 'photo.png', 'image/png');
        //dd(Storage::allFiles());
        Storage::disk('local')->assertExists("images/thumbnails/" . 'photo.png');
    }
}
