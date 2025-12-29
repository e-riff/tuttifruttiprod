<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Model\Association;
use App\Domain\Repository\AssociationRepositoryInterface;

readonly class GlobalAssociation
{
    public function __construct(private AssociationRepositoryInterface $associationRepository)
    {
    }

    public function getAssociation(): Association
    {
        return $this->associationRepository->findOneBy([]);
    }
}
