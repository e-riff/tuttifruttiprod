<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\ResetPasswordRequest;

/**
 * @extends RepositoryInterface<ResetPasswordRequest>
 */
interface ResetPasswordRequestRepositoryInterface extends RepositoryInterface
{
}
