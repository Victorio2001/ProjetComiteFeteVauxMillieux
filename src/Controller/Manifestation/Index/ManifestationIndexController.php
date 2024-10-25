<?php
// src/Controller/Manifestation/Index/ManifestationIndexController.php

namespace App\Controller\Manifestation\Index;

use App\Entity\Manifestation;
use App\Repository\ManifestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manifestation', name: 'app_')]
class ManifestationIndexController extends AbstractController
{
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    #[Route('/', name: 'manifestation_index', methods: ['GET'])]
    public function index(ManifestationRepository $manifestationRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('search', '');

        if (!empty($searchTerm)) {
            $requete = $manifestationRepository->findByTitleOrDescription($searchTerm);
        } else {
            $requete = $manifestationRepository->getAll();
        }

        $pagination = $this->paginator->paginate(
            $requete,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('manifestation/index.html.twig', [
            'manifestations' => $pagination,
            'searchTerm' => $searchTerm,
        ]);
    }
}
