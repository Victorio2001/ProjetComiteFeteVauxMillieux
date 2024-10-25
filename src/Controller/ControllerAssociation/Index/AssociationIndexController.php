<?php

namespace App\Controller\ControllerAssociation\Index;

use App\Repository\AssociationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/association')]
class AssociationIndexController extends AbstractController
{
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    #[Route('/', name: 'app_association_index', methods: ['GET'])]
    public function index(AssociationRepository $associationRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('searchAssociation', '');

        $queryBuilder = $associationRepository->createQueryBuilder('a');

        if ($searchTerm) {
            $queryBuilder->where('a.nomAssociation LIKE :searchTerm OR a.descriptionAssociation LIKE :searchTerm')
                         ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            8 // Nombre d'éléments par page
        );

        return $this->render('association/index.html.twig', [
            'pagination' => $pagination,
            'searchTerm' => $searchTerm,
        ]);
    }
}
