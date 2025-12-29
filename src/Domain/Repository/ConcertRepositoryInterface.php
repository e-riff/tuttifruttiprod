<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Band;
use App\Domain\Model\Concert;
use DateTime;

interface ConcertRepositoryInterface
{
    public function save(Concert $entity, bool $flush = false): void;

    public function remove(Concert $entity, bool $flush = false): void;

    /**
     * @return Concert[]
     */
    public function findConfirmedConcerts(?DateTime $dateToFetchFrom = null, ?Band $band = null): array;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return Concert[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return Concert[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
