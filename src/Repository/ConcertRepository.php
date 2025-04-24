<?php

namespace App\Repository;

use App\Entity\Band;
use App\Entity\Concert;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concert>
 *
 * @method Concert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concert[]    findAll()
 * @method Concert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertRepository extends ServiceEntityRepository
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
