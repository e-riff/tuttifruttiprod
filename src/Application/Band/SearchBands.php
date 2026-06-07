<?php

declare(strict_types=1);

namespace App\Application\Band;

use App\Domain\Band\BandSearchCriteria;
use App\Domain\Repository\BandRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\Band;

final readonly class SearchBands
{
    public function __construct(private BandRepositoryInterface $bandRepository)
    {
    }

    /**
     * @return Band[]
     */
    public function __invoke(BandSearchCriteria $criteria): array
    {
        return $this->bandRepository->search($criteria);
    }
}
