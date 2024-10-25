<?php

namespace App\Controller\ControllerAssociation\Create;

use App\Entity\Association;
use App\Entity\Photo;
use App\Form\AssociationType;
use App\Form\PhotoType;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Psr\Log\LoggerInterface;


#[Route('/association')]
class AssociationCreateController extends AbstractController
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


    #[Route('/create', name: 'app_association_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $association = new Association();

        $temps = new \DateTimeImmutable();
        $association->setCreatedAt($temps);
        $association->setUpdatedAt($temps);

        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($association);
            $entityManager->flush();

            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('association/new.html.twig', [
            'association' => $association,
            'form' => $form,

        ]);
    }



    #[Route('/create/photo/{id}', name: 'app_association_newPhoto', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, EntityManagerInterface $entityManager, Association $association): Response
    {

        $photo = new Photo();
        $photo->setAssociation($association);
        $temps = new \DateTimeImmutable();
        $photo->setDateImage($temps);
        $photo->setCreatedAt($temps);
        $photo->setUpdatedAt($temps);

        $formPhoto = $this->createForm(PhotoType::class, $photo);
        $formPhoto->handleRequest($request);

        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $image = $formPhoto->get('imageAsso')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('Association_directory'),
                    $newFilename
                );
                $photo->setTitreImage($newFilename);
            }

            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('association/newImage.html.twig', [
            'photo' => $photo,
            'formPhoto' => $formPhoto,
        ]);
    }
}
