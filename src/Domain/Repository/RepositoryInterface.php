<?php

declare(strict_types=1);

namespace App\Domain\Repository;

/**
 * Marker contract for domain repository ports.
 *
 * @template TEntity of object
 */
interface RepositoryInterface
{
    /**
     * @return TEntity|null
     */
    public function find(mixed $id);

    /**
     * @return TEntity[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return TEntity[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null);

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return TEntity|null
     */
    public function findOneBy(array $criteria, ?array $orderBy = null);
}
