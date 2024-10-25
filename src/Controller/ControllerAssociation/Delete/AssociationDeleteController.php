<?php

namespace App\Controller\ControllerAssociation\Delete;

use App\Entity\Association;
use App\Entity\Lier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/association')]
class AssociationDeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_association_delete', methods: ['POST'])]
    public function delete(Request $request, Association $association, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $association->getId(), $request->get('_token'))) {
            // Supprimer les relations "Lier" associées
            $liers = $association->getLiers();
            foreach ($liers as $lier) {
                $entityManager->remove($lier);
            }

            // Supprimer les photos associées
            foreach ($association->getPhotos() as $photo) {
                $entityManager->remove($photo);
            }

            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
    }
}
