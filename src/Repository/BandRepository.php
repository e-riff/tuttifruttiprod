<?php

namespace App\Repository;

use App\Entity\Band;
use App\Entity\BandPriceEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Band>
 *
 * @method Band|null find($id, $lockMode = null, $lockVersion = null)
 * @method Band|null findOneBy(array $criteria, array $orderBy = null)
 * @method Band[]    findAll()
 * @method Band[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Band::class);
    }

    public function save(Band $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Band $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function bandSearch(string $searchQuery, array $events, array $musicStyles, array $priceCategories): array
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->leftJoin('b.events', 'e')
            ->leftJoin('b.musicStyles', 'ms')
            ->andWhere('b.isActive = true');

        if ($searchQuery) {
            $queryBuilder->andWhere('b.name like :searchQuery')
                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }

        if ($events) {
            foreach ($events as $event) {
                $queryBuilder->andWhere('e.name = :event')
                    ->setParameter('event', $event);
            }
        }

        if ($musicStyles) {
            foreach ($musicStyles as $musicStyle) {
                $queryBuilder->andWhere('ms.name = :musicStyle')
                    ->setParameter('musicStyle', $musicStyle);
            }
        }

        if ($priceCategories) {
            $categoriesQuery = "";
            foreach ($priceCategories as $key => $priceCategory) {
                if ($key == 0) {
                    $categoriesQuery .= "b.priceCategory = :priceCategory" . $key . " ";
                } else {
                    $categoriesQuery .= "OR b.priceCategory = :priceCategory" . $key . " ";
                }
            }
            $queryBuilder->andWhere($categoriesQuery);
            foreach ($priceCategories as $key => $priceCategory) {
                $queryBuilder->setParameter("priceCategory" . $key, $priceCategory);
            }
        }

        $queryBuilder->orderBy("b.name");

        return $queryBuilder->getQuery()->getResult();
    }

//    /**
//     * @return Band[] Returns an array of Band objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Band
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
