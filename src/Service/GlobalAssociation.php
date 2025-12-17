<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Association;
use App\Repository\AssociationRepository;

readonly class GlobalAssociation
{
    public function __construct(private AssociationRepository $associationRepository)
    {
    }

    public function getAssociation(): Association
    {
        return $this->associationRepository->findOneBy([]);
    }
}
