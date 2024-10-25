<?php

namespace App\Controller;

use App\Form\ReponseType;
use App\Repository\ContactRepository;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    private $mailService;
    private $contactRepository;

    public function __construct(MailService $mailService, ContactRepository $contactRepository)
    {
        $this->mailService = $mailService;
        $this->contactRepository = $contactRepository;
    }

    #[Route('/contact/reponse/{id}', name: 'app_reponse')]
    public function index(Request $request, int $id): Response
    {

        $contact = $this->contactRepository->find($id);
        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }


        $form = $this->createForm(ReponseType::class, null, [
            'emailUtilisateur' => $contact->getEmail(),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $to = $contact->getEmail();
            $subject = 'Réponse mail';
            $body = $form->get('reponse')->getData();

            $this->mailService->sendEmail($to, $subject, $body);

            $this->addFlash('success', 'Votre réponse est bien envoyée');

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
            'form' => $form->createView(),
            'contact' => $contact
        ]);
    }
}
