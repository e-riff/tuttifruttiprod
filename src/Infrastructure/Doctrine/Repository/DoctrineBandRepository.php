<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Model\Band;
use App\Domain\Repository\BandRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Band>
 */
class DoctrineBandRepository extends ServiceEntityRepository implements BandRepositoryInterface
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

    /**
     * @return iterable<int, Band>
     */
    public function findAllWithPicture(): iterable
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.picture IS NOT NULL')
            ->andWhere('b.isOnHomepage = 1')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string[] $events
     * @param string[] $musicStyles
     * @param string[] $priceCategories
     *
     * @return Band[]
     */
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
            $eventsQuery = '';
            foreach ($events as $key => $event) {
                if (0 == $key) {
                    $eventsQuery .= 'e.name LIKE :event_' . $key . ' ';
                } else {
                    $eventsQuery .= 'OR e.name LIKE :event_' . $key . ' ';
                }
            }
            $queryBuilder->andWhere($eventsQuery);
            foreach ($events as $key => $event) {
                $queryBuilder->setParameter('event_' . $key, $event);
            }
        }

        if ($musicStyles) {
            $musicStylesQuery = '';
            foreach ($musicStyles as $key => $musicStyle) {
                if (0 == $key) {
                    $musicStylesQuery .= 'ms.name LIKE :musicStyle_' . $key . ' ';
                } else {
                    $musicStylesQuery .= 'OR ms.name LIKE :musicStyle_' . $key . ' ';
                }
            }
            $queryBuilder->andWhere($musicStylesQuery);
            foreach ($musicStyles as $key => $musicStyle) {
                $queryBuilder->setParameter('musicStyle_' . $key, $musicStyle);
            }
        }

        if ($priceCategories) {
            $categoriesQuery = '';
            foreach ($priceCategories as $key => $priceCategory) {
                if (0 == $key) {
                    $categoriesQuery .= 'b.priceCategory = :priceCategory' . $key . ' ';
                } else {
                    $categoriesQuery .= 'OR b.priceCategory = :priceCategory' . $key . ' ';
                }
            }
            $queryBuilder->andWhere($categoriesQuery);
            foreach ($priceCategories as $key => $priceCategory) {
                $queryBuilder->setParameter('priceCategory' . $key, $priceCategory);
            }
        }

        $queryBuilder->orderBy('b.name');

        return $queryBuilder->getQuery()->getResult();
    }
}
