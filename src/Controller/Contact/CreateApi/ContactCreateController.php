<?php
namespace App\Controller\Contact\CreateApi;


use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Service\MailService;


#[AsController]
class ContactCreateController extends AbstractController
{
    private $contactRepository;
    private $mailService;

    public function __construct(ContactRepository $contactRepository, MailService $mailService)
    {
        $this->contactRepository = $contactRepository;
        $this->mailService = $mailService;
    }

    public function __invoke(Contact $res): Contact
    {
        $this->contactRepository->save($res);

        $to = 'brun.amelie2@gmail.com';
        $subject = 'Vous avez un message ! ';
        $body = 'Venez consultez votre messagerie ! ';

        $this->mailService->sendEmail($to, $subject, $body);

        return $res;
    }
}