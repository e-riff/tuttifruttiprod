<?php

namespace App\Service;

use App\Repository\AssociationRepository;

class GlobalAssociation
{
    public function __construct(private readonly AssociationRepository $associationRepository)
    {
    }
    public function getAssociation() {
        return $this->associationRepository->findOneBy([]);
    }
}