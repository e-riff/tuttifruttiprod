<?php

declare(strict_types=1);

namespace App\Domain\Band;

use App\Domain\Enum\BandPriceEnum;

/**
 * @param string[]        $events
 * @param string[]        $musicStyles
 * @param BandPriceEnum[] $priceCategories
 */
final readonly class BandSearchCriteria
{
    public function __construct(
        public string $query = '',
        public array $events = [],
        public array $musicStyles = [],
        public array $priceCategories = [],
    ) {
    }
}
