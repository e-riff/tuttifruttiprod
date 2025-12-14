<?php

declare(strict_types=1);

namespace App\Enums;

enum MediaTypeEnum: string
{
    case YOUTUBE = 'Youtube';
    case SOUNDCLOUD = 'Soundcloud';
    case IMAGE = 'Image';
    case FACEBOOK = 'Facebook';
    case INSTAGRAM = 'Instagram';
    case OTHER = 'Other';

    public static function getType(string $testedType): self
    {
        return match ($testedType) {
            self::YOUTUBE->value => self::YOUTUBE,
            self::SOUNDCLOUD->value => self::SOUNDCLOUD,
            self::IMAGE->value => self::IMAGE,
            self::FACEBOOK->value => self::FACEBOOK,
            self::INSTAGRAM->value => self::INSTAGRAM,
            default => self::OTHER,
        };
    }

    public static function getlinks(): array
    {
        return [
            self::FACEBOOK,
            self::INSTAGRAM,
            self::OTHER,
        ];
    }
}
