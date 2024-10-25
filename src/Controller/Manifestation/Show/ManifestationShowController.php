<?php
// src/Controller/Manifestation/Show/ManifestationShowController.php

namespace App\Controller\Manifestation\Show;

use App\Entity\Manifestation;
use App\Entity\Lier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manifestation')]
class ManifestationShowController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_manifestation_show', methods: ['GET'])]
    public function show(Manifestation $manifestation): Response
    {
        // Récupérer les associations liées à cette manifestation
        $liers = $this->entityManager->getRepository(Lier::class)
            ->findBy(['manifestation' => $manifestation]);

        $associations = [];
        foreach ($liers as $lier) {
            $associations[] = $lier->getAssociation();
        }

        return $this->render('manifestation/show.html.twig', [
            'manifestation' => $manifestation,
            'associations' => $associations,
        ]);
    }
}
