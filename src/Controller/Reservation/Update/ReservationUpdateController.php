<?php

namespace App\Controller\Reservation\Update;

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
final class ReservationUpdateController extends AbstractController
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
    #[Route('/{id}/edit', name: 'reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation );
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            if ($reservation->getArchiverReservation() === true) {
                foreach ($reservation->getMaterielReservation() as $materielReservation) {
                    $materiel = $materielReservation->getMateriel();
                    $nouveauStock = $materiel->getNombreExemplaireMateriel() + $materielReservation->getQuantiteReservation();
                    $materiel->setNombreExemplaireMateriel($nouveauStock);


                    $this->emInterface->persist($materiel);
                }
            }
            $this->addFlash('success', 'Votre Modification de la réservation du réservant'.' '.$reservation->getNomUserReservation().' à bien été prise en compte.');
            $this->emInterface->flush();
            $reservation->setUpdatedAt(new \DateTime());

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }
}
