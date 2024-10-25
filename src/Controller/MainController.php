<?php
namespace App\Controller;

use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\ContactRepository;

#[Route(name: 'app_')]
final class MainController extends AbstractController //Final=> "Peut pas faire d'héritage de cette classe"
{
    protected $slugger;
    protected $emInterface;
    protected $logger;
    protected $contactRepository;
    protected $ReservationRepository;
    public function __construct(ReservationRepository $reservationRepository, LoggerInterface $logger, SluggerInterface $slugger,EntityManagerInterface $emInterface, ContactRepository $contactRepository)
    {
        $this->ReservationRepository = $reservationRepository;
        $this->logger = $logger;
        $this->slugger = $slugger;
        $this->emInterface = $emInterface;
        $this->contactRepository = $contactRepository;
    }
    #[\Symfony\Component\Routing\Annotation\Route('/', name: 'index', methods: 'GET')]
    public function __invoke(Request $request)
    {
        $countNonTraite = $this->contactRepository->countNonTraite();

        $countSuperResEnAttente = $this->ReservationRepository->countEnAttente();
        // dd(phpinfo());
        return $this->render('index/index.html.twig', [
            'default' => [],
            'countNonTraite' => $countNonTraite,
            'countSuperResEnAttente' => $countSuperResEnAttente
        ]);
    }
}