<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools;

use JuanchoSL\ImageTools\Formats\AvifImage;
use JuanchoSL\ImageTools\Formats\BmpImage;
use JuanchoSL\ImageTools\Formats\GifImage;
use JuanchoSL\ImageTools\Formats\JpegImage;
use JuanchoSL\ImageTools\Formats\PngImage;
use JuanchoSL\ImageTools\Formats\StringImage;
use JuanchoSL\ImageTools\Formats\WbmpImage;
use JuanchoSL\ImageTools\Formats\WebpImage;
use JuanchoSL\ImageTools\Formats\XbmImage;

class ImageToolsFactory
{
    public function createByFile()
    {
    }

    public function createByMediaType($mimetype)
    {
        switch ($mimetype) {
            case 'image/avif':
                $model = AvifImage::class;
                break;
            case 'image/bmp':
                $model = BmpImage::class;
                break;
            case 'image/gif':
                $model = GifImage::class;
                break;
            case 'image/jpeg':
            case 'image/jpg':
                $model = JpegImage::class;
                break;
            case 'image/png':
                $model = PngImage::class;
                break;
            case 'image/vnd.wap.wbmp':
                $model = WbmpImage::class;
                break;
            case 'image/webp':
                $model = WebpImage::class;
                break;
            case 'image/xbm':
                $model = XbmImage::class;
                break;
            default:
                $model = StringImage::class;
                break;
        }
        return $model;
    }
    public function createByExtension($extension)
    {
        switch (strtolower($extension)) {
            case 'avif':
                $model = AvifImage::class;
                break;
            case 'bmp':
                $model = BmpImage::class;
                break;
            case 'gif':
                $model = GifImage::class;
                break;
            case 'jpeg':
            case 'jpg':
                $model = JpegImage::class;
                break;
            case 'png':
                $model = PngImage::class;
                break;
            case 'wbmp':
                $model = WbmpImage::class;
                break;
            case 'webp':
                $model = WebpImage::class;
                break;
            case 'xbm':
                $model = XbmImage::class;
                break;
            default:
                $model = StringImage::class;
                break;
        }
        return $model;
    }
    public static function open(string $filepath, string $mimetype = '')
    {
        /*
              $imagetype = exif_imagetype($filepath);
              $mimetype = image_type_to_mime_type($imagetype);
      */
        $mimetype = mime_content_type($filepath);

        switch ($mimetype) {
            case 'image/avif':
                $model = AvifImage::class;
                break;
            case 'image/bmp':
                $model = BmpImage::class;
                break;
            case 'image/gif':
                $model = GifImage::class;
                break;
            case 'image/jpeg':
                $model = JpegImage::class;
                break;
            case 'image/png':
                $model = PngImage::class;
                break;
            case 'image/vnd.wap.wbmp':
                $model = WbmpImage::class;
                break;
            case 'image/webp':
                $model = WebpImage::class;
                break;
            case 'image/xbm':
                $model = XbmImage::class;
                break;
        }
        return $resource = $model::read($filepath);
        return new $model($resource);

        $extension = pathinfo($filepath, PATHINFO_EXTENSION);
        if (!empty($extension)) {
            //$model = 
        }
    }
}