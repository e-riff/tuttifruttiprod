<?php

declare(strict_types=1);

namespace App\Infrastructure\Twig;

use App\Domain\Repository\AssociationRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\Association;

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
