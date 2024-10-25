<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.dateReservation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int Returns the number of non traité contacts
     */
    public function countEnAttente(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.etat = :etat')
            ->setParameter('etat', "En attente")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAsso(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.nomAsso = :type')
            ->setParameter('type', 'association')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countParticulier(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.nomAsso = :type')
            ->setParameter('type', 'particulier')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countEncours(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.etat = :etat')
            ->setParameter('etat', "En-cours")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAnnulee(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.etat = :etat')
            ->setParameter('etat', "Annulée")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countTerminee(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.etat = :etat')
            ->setParameter('etat', "Terminée")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countArchiver(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->where('r.etat = :etat')
            ->setParameter('etat', "Archivée")
            ->getQuery()
            ->getSingleScalarResult();
    }



    public function findByCommentaire(string $email): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.commentaireReservation LIKE :searchTerm OR r.nomUserReservation LIKE :searchTerm OR r.prenomUserReservation LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$email.'%')
            ->orderBy('r.dateReservation', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function save(Reservation $reservation): void
    {
        $em = $this->getEntityManager();
        $em->persist($reservation);
        $em->flush();
    }

}
