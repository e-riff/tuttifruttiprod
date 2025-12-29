<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Media;

interface MediaRepositoryInterface
{
    public function save(Media $entity, bool $flush = false): void;

    public function remove(Media $entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return Media[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return Media[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
