<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

interface UserRepositoryInterface extends PasswordUpgraderInterface
{
    public function save(User $entity, bool $flush = false): void;

    public function remove(User $entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return User[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return User[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
