<?php


namespace App\Controller;


use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MainController
 * @package App\Controller
 * @Route ("/")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function home(EntityManagerInterface $em, UserInterface $user)
    {
        /* Récupération de la liste des campus */
        $campusRepo = $em->getRepository(Campus::class);
        $campus = $campusRepo->findAll();

        /* Récupération de la liste des sorties */
        $sortieRepo = $em->getRepository(Sortie::class);
        $sorties = $sortieRepo->findAll();

        /* Date du jour */
        $date = new \DateTime();

        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($user->getUsername());
        $user = $participant[0];
        $this->denyAccessUnlessGranted("ROLE_USER");
        return $this->render("main/home.html.twig", [
            "campus" => $campus,
            "date" => $date,
            "user" => $user,
            "sorties" => $sorties
        ]);
    }
}