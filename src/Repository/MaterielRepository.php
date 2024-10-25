<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Materiel>
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.archiver = false')
            ->orderBy('m.nomMateriel', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByTitle(string $title): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.nomMateriel LIKE :nomMateriel')
            ->setParameter('nomMateriel', '%'.$title.'%')
            ->orderBy('m.nomMateriel', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Materiel[] Returns an array of Materiel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Materiel
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
