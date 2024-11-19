<?php

namespace App\Service;

use App\Repository\AssociationRepository;

readonly class GlobalAssociation
{
    public function __construct(private AssociationRepository $associationRepository)
    {
    }
    public function getAssociation() {
        return $this->associationRepository->findOneBy([]);
    }
}