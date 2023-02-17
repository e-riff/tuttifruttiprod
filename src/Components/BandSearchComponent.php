<?php

namespace App\Components;

use App\Repository\BandRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

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


    public function __construct(private BandRepository $bandRepository)
    {
    }
    public function getBands(): array
    {
        return $this->bandRepository->bandSearch($this->searchQuery, $this->events, $this->musicStyles);
    }
}