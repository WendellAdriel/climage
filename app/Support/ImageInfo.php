<?php

declare(strict_types=1);

namespace App\Support;

final readonly class ImageInfo
{
    public function __construct(
        public string $filename,
        public int $width,
        public int $height,
    ) {
    }
}
