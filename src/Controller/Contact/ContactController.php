<?php

namespace App\Controller\Contact;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/contact')]
class ContactController extends AbstractController
{
    protected $paginator;
    protected $logger;
    protected $slugger;
    protected $emInterface;

    public function __construct(PaginatorInterface $paginator, LoggerInterface $logger, SluggerInterface $slugger, EntityManagerInterface $emInterface)
    {
        $this->paginator = $paginator;
        $this->logger = $logger;
        $this->slugger = $slugger;
        $this->emInterface = $emInterface;
    }

    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function __invoke(ContactRepository $contactRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('search', '');

        if (!empty($searchTerm)) {
            $requete = $contactRepository->findByEmail($searchTerm);
        } else {
            $requete = $contactRepository->getAll();
        }

        $paginationMateriel = $this->paginator->paginate(
            $requete,
            $request->query->getInt('page', 1),
            8
        );

        $countNonTraite = $contactRepository->countNonTraite();

        return $this->render('contact/index.html.twig', [
            'contacts' => $paginationMateriel,
            'countNonTraite' => $countNonTraite,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/traiter/{id}', name: 'app_contact_toggle', methods: ['GET', 'POST'])]
    public function toggle(Contact $contact): Response
    {
        $contact->setEtatcontact(!$contact->isEtatcontact());
        $this->emInterface->persist($contact);
        $this->emInterface->flush();

        return $this->redirectToRoute('app_contact_index');
    }
}