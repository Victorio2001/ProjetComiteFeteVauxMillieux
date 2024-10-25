<?php

namespace App\Controller\Materiel\Create;

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
final class MaterielCreateController extends AbstractController
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

    #[Route('/create', name: 'materiel_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $materiel->setUpdatedAt(new \DateTimeImmutable());
            $materiel->setCreatedAt(new \DateTimeImmutable());

            $image = $form->get('imageMateriel')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('Materiel_directory'),
                    $newFilename
                );
                $materiel->setArchiver(false);
                $materiel->setImageMateriel($newFilename);
            }else{
                $materiel->setImageMateriel('DefaultImageMateriel.jpg');
            }

            $entityManager->persist($materiel);
            $entityManager->flush();

            $this->addFlash('success', 'Votre matériel à bien été créee');


            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }
}
