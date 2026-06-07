<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Infrastructure\Doctrine\Entity\Event;

/**
 * @extends RepositoryInterface<Event>
 */
interface EventRepositoryInterface extends RepositoryInterface
{
    public function save(Event $entity, bool $flush = false): void;

    public function remove(Event $entity, bool $flush = false): void;
}
