<?php

namespace App\Controller\Materiel\Index;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
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

#[Route( path:'/materiel', name: 'app_' )]
final class MaterielIndexController extends AbstractController
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
    #[Route('/', name: 'materiel_index', methods: ['GET'])]
    public function __invoke(MaterielRepository $materielRepository, Request $request ): Response
    {
        $searchTerm = $request->query->get('search', '');

        if (!empty($searchTerm)) {
            $requete = $materielRepository->findByTitle($searchTerm);
        } else {
            $requete = $materielRepository->getAll();
        }

        $paginationMateriel = $this->paginator->paginate(
            $requete,
            $request->query->getInt('page', 1),
            8
        );


        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'Cookies eaten 🍪',
                    'backgroundColor' => 'rgb(255, 99, 132, .4)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [2, 10, 5, 18, 20, 30, 45],
                    'tension' => 0.4,
                ],
            ],
        ]);
        $chart->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $this->render('materiel/index.html.twig', [
            'materiels' => $paginationMateriel,
            'searchTerm' => $searchTerm,
            'chart' => $chart,

        ]);
    }
}
