<?php

namespace App\Controller\Materiel\Update;

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
final class MaterielUpdateController extends AbstractController
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
    #[Route('/{id}/edit', name: 'materiel_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Materiel $materiel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $materiel->setUpdatedAt(new \DateTimeImmutable());
            $image = $form->get('imageMateriel')->getData();
//          dd($form);
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('Materiel_directory'),
                    $newFilename
                );
                $materiel->setImageMateriel($newFilename);
            }else{
               $materiel->setImageMateriel($materiel->getImageMateriel());
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }
}
