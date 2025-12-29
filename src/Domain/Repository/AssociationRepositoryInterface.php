<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Association;

interface AssociationRepositoryInterface
{
    public function save(Association $entity, bool $flush = false): void;

    public function remove(Association $entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return Association[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return Association[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
