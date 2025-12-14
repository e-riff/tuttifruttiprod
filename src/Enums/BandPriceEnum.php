<?php

declare(strict_types=1);

namespace App\Enums;

enum BandPriceEnum: string
{
    case LESS_THAN_1000 = '- de 1000€';
    case BETWEEN_1000_AND_2000 = 'entre 1000€ et 2000€';
    case MORE_THAN_2000 = '+ de 2000€';

    public static function getType(?string $testedType): ?self
    {
        return match ($testedType) {
            self::LESS_THAN_1000->value => self::LESS_THAN_1000,
            self::BETWEEN_1000_AND_2000->value => self::BETWEEN_1000_AND_2000,
            self::MORE_THAN_2000->value => self::MORE_THAN_2000,
            default => null,
        };
    }
}
