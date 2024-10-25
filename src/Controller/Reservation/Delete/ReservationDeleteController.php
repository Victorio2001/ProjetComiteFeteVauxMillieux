<?php

namespace App\Controller\Reservation\Delete;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route( path:'/reservation', name: 'app_' )]
final class ReservationDeleteController extends AbstractController
{
    protected $slugger;
    protected $emInterface;
    protected $logger;
    public function __construct(LoggerInterface $logger, SluggerInterface $slugger,EntityManagerInterface $emInterface)
    {
        $this->logger = $logger;
        $this->slugger = $slugger;
        $this->emInterface = $emInterface;
    }
    #[Route('/{id}', name: 'reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
