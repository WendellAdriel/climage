<?php

declare(strict_types=1);

namespace App\Command\Convert;

use App\Command\BaseController;
use App\Enums\ImageFormat;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFormatException;

final class DefaultController extends BaseController
{
    /**
     * @throws FileNotFoundException|InvalidFormatException
     */
    public function handle(): void
    {
        $imagePath = $this->ask($this->buildQuestion('Which image do you want to convert?'));

        if ( ! realpath($imagePath)) {
            throw new FileNotFoundException();
        }

        $imageInfo = $this->app->image->info($imagePath);
        $this->printImageInfo($imageInfo);

        $allowedFormats = ImageFormat::allowedFormats();
        $newFormat = $this->ask(
            $this->buildQuestion('What is the new FORMAT? ['.implode(', ', $allowedFormats).']')
        );

        if ( ! in_array($newFormat, $allowedFormats)) {
            throw new InvalidFormatException();
        }

        $result = $this->app->image->convert($imagePath, ImageFormat::from($newFormat), $this->app->config->output_path);

        $this->successMessage('The image was converted successfully! Check the details below:');
        $this->printImageInfo($result);
    }
}
