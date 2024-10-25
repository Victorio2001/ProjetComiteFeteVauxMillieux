<?php

namespace App\Controller\Manifestation\Create;

use App\Entity\Manifestation;
use App\Entity\Photo;
use App\Form\ManifestationType;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Psr\Log\LoggerInterface;

#[Route('/manifestation')]
class ManifestationCreateController extends AbstractController
{
    protected $slugger;
    protected $emInterface;
    protected $logger;

    public function __construct(LoggerInterface $logger, SluggerInterface $slugger, EntityManagerInterface $emInterface)
    {
        $this->logger = $logger;
        $this->slugger = $slugger;
        $this->emInterface = $emInterface;
    }

    #[Route('/create', name: 'app_manifestation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manifestation = new Manifestation();
        $temps = new \DateTimeImmutable();
        $manifestation->setCreatedAt($temps);
        $manifestation->setUpdatedAt($temps);

        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($manifestation);
            $entityManager->flush();

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manifestation/new.html.twig', [
            'manifestation' => $manifestation,
            'form' => $form,
        ]);
    }

    #[Route('/create/photo/{id}', name: 'app_manifestation_newPhoto', methods: ['GET', 'POST'])]
    public function newPhoto(Request $request, EntityManagerInterface $entityManager, Manifestation $manifestation): Response
    {
        $photo = new Photo();
        $photo->setManifestation($manifestation);

        // Initialiser les dates
        $dateTimeNow = new \DateTime();
        $photo->setDateImage($dateTimeNow);
        $photo->setCreatedAt($dateTimeNow);
        $photo->setUpdatedAt($dateTimeNow);

        $formPhoto = $this->createForm(PhotoType::class, $photo);
        $formPhoto->handleRequest($request);

        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $image = $formPhoto->get('imageAsso')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('Manifestation_directory'),
                    $newFilename
                );
                $photo->setTitreImage($newFilename);
            }

            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manifestation/newImage.html.twig', [
            'photo' => $photo,
            'formPhoto' => $formPhoto,
        ]);
    }
}
