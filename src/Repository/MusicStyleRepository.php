<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MusicStyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MusicStyle>
 *
 * @method MusicStyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicStyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicStyle[]    findAll()
 * @method MusicStyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicStyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusicStyle::class);
    }

    public function save(MusicStyle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MusicStyle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
