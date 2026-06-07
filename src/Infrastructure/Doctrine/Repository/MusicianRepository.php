<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Repository\MusicianRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\Musician;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Musician>
 *
 * @method Musician|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musician|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musician[]    findAll()
 * @method Musician[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicianRepository extends ServiceEntityRepository implements MusicianRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Musician::class);
    }

    public function save(Musician $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Musician $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
