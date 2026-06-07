<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\Musician;

/**
 * @extends RepositoryInterface<Musician>
 */
interface MusicianRepositoryInterface extends RepositoryInterface
{
    public function save(Musician $entity, bool $flush = false): void;

    public function remove(Musician $entity, bool $flush = false): void;
}
