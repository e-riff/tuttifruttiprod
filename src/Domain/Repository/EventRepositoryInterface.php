<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Event;

interface EventRepositoryInterface
{
    public function save(Event $entity, bool $flush = false): void;

    public function remove(Event $entity, bool $flush = false): void;

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * @return Event[]
     */
    public function findAll();

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     *
     * @return Event[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}
