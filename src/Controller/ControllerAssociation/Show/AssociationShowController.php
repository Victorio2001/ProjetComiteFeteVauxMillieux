<?php
namespace App\Controller\ControllerAssociation\Show;

use App\Entity\Association;
use App\Entity\Lier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/association')]
class AssociationShowController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_association_show', methods: ['GET'])]
    public function show(Association $association): Response
    {
        // Récupérer les manifestations associées à cette association
        $liers = $this->entityManager->getRepository(Lier::class)
            ->findBy(['association' => $association]);

        $manifestations = [];
        foreach ($liers as $lier) {
            $manifestations[] = $lier->getManifestation();
        }

        return $this->render('association/show.html.twig', [
            'association' => $association,
            'manifestations' => $manifestations,
        ]);
    }
}
