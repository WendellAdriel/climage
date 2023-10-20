<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ImageFormat;
use App\Support\ImageInfo;
use Imagick;
use ImagickException;
use Minicli\App;
use Minicli\ServiceInterface;

final class ImageService implements ServiceInterface
{
    /**
     * @throws ImagickException
     */
    public function info(string $imagePath): ImageInfo
    {
        $image = $this->read($imagePath);

        return new ImageInfo(
            filename: basename($imagePath),
            width: $image->getImageWidth(),
            height: $image->getImageHeight(),
        );
    }

    /**
     * @throws ImagickException
     */
    public function resize(string $imagePath, int $width, int $height, string $outputPath): ImageInfo
    {
        $image = $this->read($imagePath);

        $image->resizeImage(
            columns: $width,
            rows: $height,
            filter: Imagick::FILTER_UNDEFINED,
            blur: 1,
            bestfit: true
        );

        $filename = basename($imagePath);
        $output = "{$outputPath}/{$filename}";
        $image->writeImage($output);

        return new ImageInfo(
            filename: $output,
            width: $width,
            height: $height,
        );
    }

    /**
     * @throws ImagickException
     */
    public function convert(string $imagePath, ImageFormat $format, string $outputPath): ImageInfo
    {
        $image = $this->read($imagePath);

        $image->setImageFormat($format->value);

        $filename = pathinfo($imagePath, PATHINFO_FILENAME).".{$format->value}";
        $output = "{$outputPath}/{$filename}";
        $image->writeImage($output);

        return new ImageInfo(
            filename: $output,
            width: $image->getImageWidth(),
            height: $image->getImageHeight(),
        );
    }

    /**
     * @throws ImagickException
     */
    private function read(string $imagePath): Imagick
    {
        $image = new Imagick();
        $image->readImage($imagePath);

        return $image;
    }

    public function load(App $app): void
    {
        // Nothing to do here
    }
}
