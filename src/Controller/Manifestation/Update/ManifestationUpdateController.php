<?php

namespace App\Controller\Manifestation\Update;

use App\Entity\Manifestation;
use App\Entity\Photo;
use App\Form\ManifestationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/manifestation', name: 'app_')]
class ManifestationUpdateController extends AbstractController
{
    #[Route('/{id}/edit', name: 'manifestation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manifestation $manifestation, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('Manifestation_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                $photo = new Photo();
                $photo->setTitreImage($newFilename);
                $photo->setManifestation($manifestation);

                $entityManager->persist($photo);
                $manifestation->addPhoto($photo);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manifestation/edit.html.twig', [
            'manifestation' => $manifestation,
            'form' => $form,
        ]);
    }
}
