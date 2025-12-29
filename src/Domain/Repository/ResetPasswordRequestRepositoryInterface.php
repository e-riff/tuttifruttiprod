<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\ResetPasswordRequest;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface as SymfonyResetPasswordRequestRepositoryInterface;

interface ResetPasswordRequestRepositoryInterface extends SymfonyResetPasswordRequestRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return ResetPasswordRequest[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return ResetPasswordRequest[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
