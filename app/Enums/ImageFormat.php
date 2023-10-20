<?php

declare(strict_types=1);

namespace App\Enums;

enum ImageFormat: string
{
    case JPEG = 'jpeg';

    case PNG = 'png';

    public static function allowedFormats(): array
    {
        return array_map(fn ($item) => $item->value, self::cases());
    }
}
