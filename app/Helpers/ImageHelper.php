<?php


namespace App\Helpers;


use InvalidArgumentException;

class ImageHelper
{
    /**
     * Take an image file and return thumbnail GD resource.
     *
     * @param $file
     * @param int $width
     * @param int $height
     * @return false|resource
     */
    public static function createThumbnailFromImage($file, int $width, int $height)
    {
        $type = ImageHelper::determineImageFiletype($file);
        $image = ImageHelper::createImageFromFile($file, $type);
        return ImageHelper::cropImageToCenter($image, $width, $height);
    }

    /**
     * Take an image GD resource and crop it to the desired size with central alignment.
     *
     * @param $image
     * @param int $cropWidth
     * @param int $cropHeight
     * @return false|resource
     */
    public static function cropImageToCenter($image, int $cropWidth, int $cropHeight)
    {
        $width  = imagesx($image);
        $height = imagesy($image);
        $centreX = round($width / 2);
        $centreY = round($height / 2);

        $cropWidthHalf  = round($cropWidth / 2);
        $cropHeightHalf = round($cropHeight / 2);

        $x1 = max(0, $centreX - $cropWidthHalf);
        $y1 = max(0, $centreY - $cropHeightHalf);

        $x2 = min($width, $centreX + $cropWidthHalf);
        $y2 = min($height, $centreY + $cropHeightHalf);

        $result  = imagecreatetruecolor($cropWidth, $cropHeight);

        imagecopy($result, $image, 0,0,$x1, $y1, $x2, $y2);
        return  $result;
    }

    /**
     * Return filetype as string of an image file.
     *
     * @param $file
     * @return string
     */
    public static function determineImageFiletype($file): string
    {
        return getimagesize($file)['mime'];
    }

    /**
     * Create a GD image resource from file of given filetype.
     *
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
