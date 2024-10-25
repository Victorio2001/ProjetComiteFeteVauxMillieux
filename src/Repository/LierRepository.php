<?php

namespace App\Repository;

use App\Entity\Lier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lier>
 */
class LierRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Lier::class);
    }

    //    /**

    //     * @return Lier[] Returns an array of Lier objects

    //     */

    //    public function findByExampleField($value): array

    
}