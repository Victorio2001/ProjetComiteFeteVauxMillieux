<?php

namespace App\Controller\Materiel\Delete;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route( path:'/materiel', name: 'app_' )]
final class MaterielDeleteController extends AbstractController
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
    #[Route('/{id}', name: 'materiel_delete', methods: ['POST'])]
    public function __invoke(Request $request, Materiel $materiel, EntityManagerInterface $entityManager): Response
    {

        if ($this->isCsrfTokenValid('delete'.$materiel->getId(), $request->getPayload()->get('_token'))) {
            $this->addFlash('success', 'Matériel supprimé '.$materiel->getNomMateriel());
            $materiel->setArchiver(true);
//            $entityManager->remove($materiel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
    }
}
