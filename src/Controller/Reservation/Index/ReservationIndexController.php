<?php

namespace App\Controller\Reservation\Index;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route( path:'/reservation', name: 'app_' )]
final class ReservationIndexController extends AbstractController
{
    protected $slugger;
    protected $paginator;
    protected $emInterface;
    protected $logger;
    private $chartBuilder;
    public function __construct(ChartBuilderInterface $chartBuilder, PaginatorInterface $paginator,LoggerInterface $logger, SluggerInterface $slugger,EntityManagerInterface $emInterface)
    {
        $this->chartBuilder = $chartBuilder;
        $this->paginator = $paginator;
        $this->logger = $logger;
        $this->slugger = $slugger;
        $this->emInterface = $emInterface;
    }
    #[Route('/', name: 'reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository, Request $request): Response
    {

        $searchTerm = $request->query->get('search', '');

        if (!empty($searchTerm)) {
            $requete = $reservationRepository->findByCommentaire($searchTerm);
        } else {
            $requete = $reservationRepository->getAll();
        }


        $NbrAsso = $reservationRepository->countAsso();
        $NbrParticulier = $reservationRepository->countParticulier();

        $chart2 = $this->chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chart2->setData([
            'labels' => ['Association', 'Particulier'],
            'datasets' => [
                [
                    'label' => 'Statut Réservation(s)',
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',

                    ],
                    'borderWidth' => 1,
                    'data' => [$NbrAsso, $NbrParticulier ],
                        'tension' => 0.4,
                    ],
                ],
           ]);

        $chart2->setOptions([
            'maintainAspectRatio' => false,
        ]);




        $NbrEtatAttente = $reservationRepository->countEnAttente();
        $NbrEtatEnCours = $reservationRepository->countEncours();
        $NbrEtatAnnulee = $reservationRepository->countAnnulee();
        $NbrEtatTerminee = $reservationRepository->countTerminee();
        $NbrEtatArchiver = $reservationRepository->countArchiver();

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => ['En attente', 'En-Cours', 'Annulée', 'Terminée', 'Archivée'],
            'datasets' => [
                [
                    'label' => 'Etat Réservation(s)',
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)', // En attente
                        'rgba(54, 162, 235, 0.2)', // En-Cours
                        'rgba(255, 206, 86, 0.2)', // Annulée
                        'rgba(75, 192, 192, 0.2)', // Terminée
                        'rgba(153, 102, 255, 0.2)' // Archivée
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)', // En attente
                        'rgba(54, 162, 235, 1)', // En-Cours
                        'rgba(255, 206, 86, 1)', // Annulée
                        'rgba(75, 192, 192, 1)', // Terminée
                        'rgba(153, 102, 255, 1)' // Archivée
                    ],
                    'borderWidth' => 1,
                    'data' => [$NbrEtatAttente, $NbrEtatEnCours, $NbrEtatAnnulee, $NbrEtatTerminee, $NbrEtatArchiver],
                    'tension' => 0.4,
                ],
            ],
        ]);

        $chart->setOptions([
            'maintainAspectRatio' => false,
        ]);

        $paginationReservation = $this->paginator->paginate(
            $requete,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('reservation/index.html.twig', [
            'reservations' => $paginationReservation,
            'NbrEtatAttente' => $NbrEtatAttente,
            'chart' => $chart,
            'chart2' => $chart2,
            'searchTerm' => $searchTerm,
        ]);
    }
}
