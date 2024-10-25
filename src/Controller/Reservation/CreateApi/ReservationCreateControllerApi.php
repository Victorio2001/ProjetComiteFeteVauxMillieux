<?php
namespace App\Controller\Reservation\CreateApi;

use App\Entity\Materiel;
use App\Entity\MaterielReservation;
use App\Entity\Reservation;
use App\Repository\MaterielRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Service\MailService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class ReservationCreateControllerApi extends AbstractController
{

    private $reservationRepository;
    private $materielRepository;
    private $userRepository;
    private $entityManager;
    private $mailService;

    public function __construct(
        ReservationRepository $reservationRepository,
        MaterielRepository $materielRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        MailService $mailService
    )
    {
        $this->reservationRepository = $reservationRepository;
        $this->materielRepository = $materielRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            throw new BadRequestHttpException('Json Incorrect');
        }

        $reservation = new Reservation();
        $reservation->setDateReservation(new \DateTime());
        $reservation->setCommentaireReservation($data['commentaireReservation']);
        $reservation->setEtat($data['etat']);
        $reservation->setArchiverReservation($data['archiverReservation']);
        $reservation->setDateRetour(new \DateTime($data['dateRetour']));
        $reservation->setDateEmprunt(new \DateTime($data['dateEmprunt']));
        $reservation->setCreatedAt(new \DateTime());
        $reservation->setUpdatedAt(new \DateTime());

        $reservation->setMailReservation($data['mailReservation']);
        $reservation->setNomAsso($data['nomAsso']);
        $reservation->setNomUserReservation($data['nomUserReservation']);
        $reservation->setPrenomUserReservation($data['prenomUserReservation']);
        $reservation->setNumeroReservant($data['numeroReservant']);

        foreach ($data['MaterielReservation'] as $materielReservationData) {

            $iriParts = explode('/', $materielReservationData['materiel']);
            $materielId = end($iriParts);

            $materiel = $this->materielRepository->find($materielId);
            if ($materiel) {
                $materielReservation = new MaterielReservation();
                $materielReservation->setQuantiteReservation($materielReservationData['quantiteReservation']);
                $materielReservation->setPrixOrigine($materielReservationData['prixOrigine']);

                $materielReservation->setMateriel($materiel);

                $nouveauStock = $materiel->getNombreExemplaireMateriel() - $materielReservationData['quantiteReservation'];
                if ($nouveauStock < 0) {
                    throw new BadRequestHttpException('Stock insuffisant pour le matériel: ' . $materiel->getNomMateriel());
                }
                $materiel->setNombreExemplaireMateriel($nouveauStock);

                $reservation->addMaterielReservation($materielReservation);
                $this->entityManager->persist($materielReservation);
            } else {
                throw new BadRequestHttpException('Problèemmmme: ' . $materielReservationData['materiel']);
            }
        }
        $this->reservationRepository->save($reservation);
        $this->entityManager->flush();

        $to = 'victoriogarciapro@gmail.com';
        $subject = 'Nouvelle reservation creee';
        $body = 'Une nouvelle réservation a été créée avec succès. Vous pouvez consulter la réservation sur votre tableau de bord.';

        $this->mailService->sendEmail($to, $subject, $body);

        return new JsonResponse(['status' => 'La réservation est créée'], Response::HTTP_CREATED);
    }
}