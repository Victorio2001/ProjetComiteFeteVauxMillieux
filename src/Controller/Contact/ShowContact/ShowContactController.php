<?php

namespace App\Controller\Contact\ShowContact;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact/{id}', name: 'app_contact_show', methods: ['GET'])]
class ShowContactController extends AbstractController
{
    public function __invoke(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }
}
