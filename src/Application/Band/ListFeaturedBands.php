<?php

declare(strict_types=1);

namespace App\Application\Band;

use App\Domain\Repository\BandRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\Band;

final readonly class ListFeaturedBands
{
    public function __construct(private BandRepositoryInterface $bandRepository)
    {
    }

    /**
     * @return Band[]
     */
    public function __invoke(int $limit = 6): array
    {
        return $this->bandRepository->findRandomActiveForHomepage($limit);
    }
}
