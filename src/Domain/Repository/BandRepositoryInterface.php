<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Band\BandSearchCriteria;
use App\Infrastructure\Doctrine\Entity\Band;

/**
 * @extends RepositoryInterface<Band>
 */
interface BandRepositoryInterface extends RepositoryInterface
{
    public function save(Band $entity, bool $flush = false): void;

    public function remove(Band $entity, bool $flush = false): void;

    /**
     * @return iterable<Band>
     */
    public function findAllWithPicture(): iterable;

    /**
     * @return Band[]
     */
    public function findRandomActiveForHomepage(int $limit = 6): array;

    /**
     * @return Band[]
     */
    public function search(BandSearchCriteria $criteria): array;

    /**
     * @param string[] $events
     * @param string[] $musicStyles
     * @param mixed[]  $priceCategories
     *
     * @return Band[]
     */
    public function bandSearch(string $searchQuery, array $events, array $musicStyles, array $priceCategories): array;
}
