<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity\Behavior;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait IdentifiableTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null; // @phpstan-ignore-line

    public function getId(): ?int
    {
        return $this->id;
    }
}
