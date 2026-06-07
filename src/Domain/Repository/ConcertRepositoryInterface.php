<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\Band;
use App\Infrastructure\Doctrine\Entity\Concert;
use DateTime;

/**
 * @extends RepositoryInterface<Concert>
 */
interface ConcertRepositoryInterface extends RepositoryInterface
{
    public function save(Concert $entity, bool $flush = false): void;

    public function remove(Concert $entity, bool $flush = false): void;

    /**
     * @return Concert[]
     */
    public function findConfirmedConcerts(?DateTime $dateToFetchFrom = null, ?Band $band = null): array;
}
