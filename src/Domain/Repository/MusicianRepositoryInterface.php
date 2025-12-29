<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Musician;

interface MusicianRepositoryInterface
{
    public function save(Musician $entity, bool $flush = false): void;

    public function remove(Musician $entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return Musician[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return Musician[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
