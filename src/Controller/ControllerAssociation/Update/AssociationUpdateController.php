<?php

namespace App\Controller\ControllerAssociation\Update;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Psr\Log\LoggerInterface;
use App\Entity\Photo;
use App\Form\PhotoType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/association')]
class AssociationUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_association_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Association $association, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $association->setUpdatedAt(new \DateTimeImmutable());

            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    #[Route('/association/edit/photo/{id}', name: 'app_association_editPhoto', methods: ['GET', 'POST'])]
public function editPhoto(Request $request, Photo $photo, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
{
    $formPhoto = $this->createForm(PhotoType::class, $photo);
    $formPhoto->handleRequest($request);

    if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
        $image = $formPhoto->get('imageAsso')->getData();
        if ($image) {
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            try {
                $image->move(
                    $this->getParameter('Association_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'Image upload failed: '.$e->getMessage());
            }

            $photo->setTitreImage($newFilename);
        }

        $photo->setUpdatedAt(new \DateTime()); // Update the updated_at field

        $entityManager->flush();

        return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('association/editImage.html.twig', [
        'photo' => $photo,
        'formPhoto' => $formPhoto->createView(),
    ]);
}

}
