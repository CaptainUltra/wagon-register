<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use InvalidArgumentException;

class ImageHelper
{
    /**
     * Take an image file, create a thumbnail with desired size and save it.
     *
     * @param $file
     * @param string $fileName
     * @param int $width
     * @param int $height
     */
    public static function createThumbnailFromImage($file, string $fileName, int $width, int $height): void
    {
        $image = ImageManagerStatic::make($file);
        $type = $image->mime();

        //Resize
        if($width > $height){
            ImageHelper::resizeToHeight($image, $height);
        }
        else{
            ImageHelper::resizeToWidth($image, $width);
        }

        //Crop
        ImageHelper::cropImageToCenter($image, $width, $height);
        //Save
        ImageHelper::saveImageToStorage($image, $fileName, $type);
    }

    /**
     * Take an Intervention Image and crop it to the desired size with central alignment.
     *
     * @param \Intervention\Image\Image $image
     * @param int $cropWidth
     * @param int $cropHeight
     * @return \Intervention\Image\Image
     */
    public static function cropImageToCenter(\Intervention\Image\Image  $image, int $cropWidth, int $cropHeight)
    {
        $image->crop($cropWidth, $cropHeight);

        return $image;
    }

    /**
     * Resize a given Intervention Image to specified heigh while conserving aspect ratio.
     *
     * @param \Intervention\Image\Image $image
     * @param int $newHeight
     * @return \Intervention\Image\Image
     */
    public static function resizeToHeight(\Intervention\Image\Image $image, int $newHeight)
    {
        $image->resize(null, $newHeight, function ($constraint) {
            $constraint->aspectRatio();});

        return $image;
    }

    /**
     * Resize a given Intervention Image to specified width while conserving aspect ratio.
     *
     * @param \Intervention\Image\Image $image
     * @param int $newWidth
     * @return \Intervention\Image\Image
     */
    public static function resizeToWidth(\Intervention\Image\Image $image, int $newWidth)
    {
        $image->resize($newWidth, null, function ($constraint) {
            $constraint->aspectRatio();});

        return $image;
    }

    public static function saveImageToStorage(\Intervention\Image\Image $image, string $fileName, string $fileType)
    {
        switch ($fileType) {
            case 'image/jpeg':
                $image = imagejpeg($image, $fileName);
                //Storage::putFile('images/thumbnails', $image);
                break;
            case 'image/png':
                $file = $image->encode('png');
                Storage::put('images/thumbnails/' . $fileName, $file->__toString());
                break;
            default:
                throw new InvalidArgumentException("Filetype $fileType is not supported.");
        }
    }
}
