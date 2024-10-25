<?php
// src/Repository/ManifestationRepository.php

namespace App\Repository;

use App\Entity\Manifestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Manifestation>
 */
class ManifestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manifestation::class);
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.dateDebutManifestation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByTitleOrDescription(string $searchTerm): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.titreManifestation LIKE :searchTerm')
            ->orWhere('m.descriptionManifestation LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->orderBy('m.dateDebutManifestation', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
