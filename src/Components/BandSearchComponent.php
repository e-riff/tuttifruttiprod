<?php

namespace App\Components;

use App\Enums\BandPriceEnum;
use App\Repository\BandRepository;
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

    public function __construct(private readonly BandRepository $bandRepository)
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