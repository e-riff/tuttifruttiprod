<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\Association;

/**
 * @extends RepositoryInterface<Association>
 */
interface AssociationRepositoryInterface extends RepositoryInterface
{
    public function save(Association $entity, bool $flush = false): void;

    public function remove(Association $entity, bool $flush = false): void;
}
