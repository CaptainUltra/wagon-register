<?php


namespace App\Helpers;


use InvalidArgumentException;

class ImageHelper
{
    /**
     * Take an image and return a thumbnail.
     *
     * @param mixed $file Image file contents
     * @param int $width Desired thumbnail width
     * @param int $height Desired thumbnail height
     */
    public static function createThumbnailFromImage($file, int $width, int $height): ?object
    {
        $type = ImageHelper::determineImageFiletype($file);
        $image = ImageHelper::createImageFromFile($file, $type);
        //TODO
    }

    public static function cropImage($file, int $width, int $height): ?object
    {
        //TODO
    }

    public static function determineImageFiletype($file): string
    {
        return getimagesize($file)['mime'];
    }

    /**
     * @param mixed $file
     * @param string $filetype
     * @return false|resource
     * @throws InvalidArgumentException
     */
    public static function createImageFromFile($file, string $filetype)
    {
        switch ($filetype) {
            case 'image/jpeg' :
                return imagecreatefromjpeg($file);
                break;
            case 'image/png'  :
                return imagecreatefrompng($file);
                break;
            default             :
                throw new InvalidArgumentException("Filetype $filetype is not suppported.");
        }
    }


}
