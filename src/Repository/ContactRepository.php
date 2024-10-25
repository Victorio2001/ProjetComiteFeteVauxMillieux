<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return Contact[] Returns an array of Contact objects sorted by etatcontact
     */
    public function getAll(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.etatcontact', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int Returns the number of non traité contacts
     */
    public function countNonTraite(): int
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->where('c.etatcontact = :etat')
            ->setParameter('etat', false)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByEmail(string $email): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.email LIKE :email')
            ->setParameter('email', '%'.$email.'%')
            ->orderBy('c.create_at', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function save(Contact $contact): void
    {
        $em = $this->getEntityManager();
        $em->persist($contact);
        $em->flush();
    }
}

