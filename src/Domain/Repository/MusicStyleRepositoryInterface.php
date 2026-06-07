<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\MusicStyle;

/**
 * @extends RepositoryInterface<MusicStyle>
 */
interface MusicStyleRepositoryInterface extends RepositoryInterface
{
    public function save(MusicStyle $entity, bool $flush = false): void;

    public function remove(MusicStyle $entity, bool $flush = false): void;
}
