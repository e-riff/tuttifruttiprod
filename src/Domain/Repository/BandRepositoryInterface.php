<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Band;

interface BandRepositoryInterface
{
    public function save(Band $entity, bool $flush = false): void;

    public function remove(Band $entity, bool $flush = false): void;

    /**
     * @return iterable<int, Band>
     */
    public function findAllWithPicture(): iterable;

    /**
     * @param string[] $events
     * @param string[] $musicStyles
     * @param string[] $priceCategories
     *
     * @return Band[]
     */
    public function bandSearch(string $searchQuery, array $events, array $musicStyles, array $priceCategories): array;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return Band[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return Band[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
