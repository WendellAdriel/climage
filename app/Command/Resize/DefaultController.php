<?php

declare(strict_types=1);

namespace App\Command\Resize;

use App\Command\BaseController;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidDimensionException;

final class DefaultController extends BaseController
{
    /**
     * @throws FileNotFoundException|InvalidDimensionException
     */
    public function handle(): void
    {
        $imagePath = $this->ask($this->buildQuestion('Which image do you want to resize?'));

        if ( ! realpath($imagePath)) {
            throw new FileNotFoundException();
        }

        $imageInfo = $this->app->image->info($imagePath);
        $this->printImageInfo($imageInfo);

        $newWidth = $this->ask(
            $this->buildQuestion("What is the new WIDTH? [Choose a value between 10 and {$imageInfo->width}]")
        );

        if ($newWidth < 10 || $newWidth > $imageInfo->width) {
            throw new InvalidDimensionException($imageInfo->width);
        }

        $newHeight = $this->ask(
            $this->buildQuestion("What is the new HEIGHT? [Choose a value between 10 and {$imageInfo->height}]")
        );

        if ($newHeight < 10 || $newHeight > $imageInfo->height) {
            throw new InvalidDimensionException($imageInfo->height);
        }

        $result = $this->app->image->resize($imagePath, (int) $newWidth, (int) $newHeight, $this->app->config->output_path);

        $this->successMessage('The image was resized successfully! Check the details below:');
        $this->printImageInfo($result);
    }
}
