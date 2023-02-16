<?php

namespace App\Entity;

enum MediaTypeEnum: string
{
    case YOUTUBE = 'Youtube';
    case SOUNDCLOUD = 'Soundcloud';
    case IMAGE = 'Image';
    case FACEBOOK = 'Facebook';
    case INSTAGRAM = 'Instagram';
    case OTHER = 'Other';

    /*public function getIcon(): string
    {
        return match ($this) {
            self::Youtube => 'bi bi-youtube',
            self::Soundcloud => 'bi bi-soundwave',
            self::Image => 'bi bi-image',
            self::Facebook => 'bi bi-facebook',
            self::Instagram => 'bi bi-instagram',
            default => 'bi bi-link',
        };
        };*/

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
