<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\MusicStyle;

interface MusicStyleRepositoryInterface
{
    public function save(MusicStyle $entity, bool $flush = false): void;

    public function remove(MusicStyle $entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return MusicStyle[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return MusicStyle[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
