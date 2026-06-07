<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\User;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $entity, bool $flush = false): void;

    public function remove(User $entity, bool $flush = false): void;
}
