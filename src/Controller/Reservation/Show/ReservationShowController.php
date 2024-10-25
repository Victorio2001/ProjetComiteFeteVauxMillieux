<?php

namespace App\Controller\Reservation\Show;

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
final class ReservationShowController extends AbstractController
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
    #[Route('/{id}', name: 'reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        $materielReservations = $reservation->getMaterielReservation();
        $reservationMateriels = [];
        foreach ($materielReservations as $materielReservation) {
            $reservationMateriels[] = $materielReservation;
        }
//      dd($materiels);
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'materielsReservation' => $reservationMateriels
        ]);
    }
}
