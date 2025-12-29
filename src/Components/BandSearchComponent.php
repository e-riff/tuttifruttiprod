<?php

declare(strict_types=1);

namespace App\Components;

use App\Domain\Repository\BandRepositoryInterface;
use App\Enums\BandPriceEnum;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('band_search')]
class BandSearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?array $searchData;

    #[LiveProp(writable: true)]
    public ?string $searchQuery;

    #[LiveProp(writable: true)]
    public ?array $events;

    #[LiveProp(writable: true)]
    public ?array $musicStyles;

    #[LiveProp(writable: true)]
    public ?array $priceCategory;

    public function __construct(private readonly BandRepositoryInterface $bandRepository)
    {
    }

    public function getBands(): array
    {
        foreach ($this->priceCategory as &$priceCategory) {
            $priceCategory = is_string($priceCategory) ? BandPriceEnum::getType($priceCategory) : $priceCategory;
        }

        return $this->bandRepository->bandSearch(
            $this->searchQuery,
            $this->events,
            $this->musicStyles,
            $this->priceCategory
        );
    }
}
