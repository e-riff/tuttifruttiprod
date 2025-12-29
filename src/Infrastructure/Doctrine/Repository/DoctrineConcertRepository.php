<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\Band;
use App\Domain\Model\Concert;
use App\Domain\Repository\ConcertRepositoryInterface;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concert>
 */
class DoctrineConcertRepository extends ServiceEntityRepository implements ConcertRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concert::class);
    }

    public function save(Concert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Concert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Concert[]
     */
    public function findConfirmedConcerts(?DateTime $dateToFetchFrom = null, ?Band $band = null): array
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.isConfirmed = :isConfirmed')
            ->setParameter('isConfirmed', true);

        if ($dateToFetchFrom) {
            $qb->andWhere('c.date >= :dateToFetchFrom')
                ->setParameter('dateToFetchFrom', $dateToFetchFrom);
        }

        if ($band) {
            $qb->andWhere('c.band = :band')
                ->setParameter('band', $band);
        }

        $qb->orderBy('c.date', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
