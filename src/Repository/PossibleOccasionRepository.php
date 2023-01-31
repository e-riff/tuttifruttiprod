<?php

namespace App\Repository;

use App\Entity\PossibleOccasion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PossibleOccasion>
 *
 * @method PossibleOccasion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PossibleOccasion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PossibleOccasion[]    findAll()
 * @method PossibleOccasion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossibleOccasionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PossibleOccasion::class);
    }

    public function save(PossibleOccasion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PossibleOccasion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PossibleOccasion[] Returns an array of PossibleOccasion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PossibleOccasion
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
