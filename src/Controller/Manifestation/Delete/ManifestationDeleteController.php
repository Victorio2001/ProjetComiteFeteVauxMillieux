<?php

namespace App\Controller\Manifestation\Delete;

use App\Entity\Manifestation;
use App\Entity\Photo;
use App\Repository\ManifestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manifestation', name: 'app_')]
class ManifestationDeleteController extends AbstractController
{
    #[Route('/{id}', name: 'manifestation_delete', methods: ['POST'])]
    public function delete(Request $request, Manifestation $manifestation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manifestation->getId(), $request->get('_token'))) {
            // Supprimer toutes les photos associées avant de supprimer la manifestation
            foreach ($manifestation->getPhotos() as $photo) {
                $entityManager->remove($photo);
            }
            
            $entityManager->remove($manifestation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
    }
}
