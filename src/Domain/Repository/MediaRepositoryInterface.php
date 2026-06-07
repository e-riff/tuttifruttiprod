<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\Media;

/**
 * @extends RepositoryInterface<Media>
 */
interface MediaRepositoryInterface extends RepositoryInterface
{
    public function save(Media $entity, bool $flush = false): void;

    public function remove(Media $entity, bool $flush = false): void;
}
