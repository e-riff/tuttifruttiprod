<?php

namespace App\Repository;

use App\Entity\Band;
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

    public function findAllWithPicture()
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.picture IS NOT NULL')
            ->getQuery()
            ->getResult();
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
            $eventsQuery = "";
            foreach ($events as $key => $event) {
                if ($key == 0) {
                    $eventsQuery .= 'e.name LIKE :event_' . $key . " ";
                } else {
                    $eventsQuery .= "OR e.name LIKE :event_" . $key . " ";
                }
            }
            $queryBuilder->andWhere($eventsQuery);
            foreach ($events as $key => $event) {
                $queryBuilder->setParameter("event_" . $key, $event);
            }
        }


        if ($musicStyles) {
            $musicStylesQuery = "";
            foreach ($musicStyles as $key => $musicStyle) {
                if ($key == 0) {
                    $musicStylesQuery .= 'ms.name LIKE :musicStyle_' . $key . " ";
                } else {
                    $musicStylesQuery .= "OR ms.name LIKE :musicStyle_" . $key . " ";
                }
            }
            $queryBuilder->andWhere($musicStylesQuery);
            foreach ($musicStyles as $key => $musicStyle) {
                $queryBuilder->setParameter("musicStyle_" . $key, $musicStyle);
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
}
