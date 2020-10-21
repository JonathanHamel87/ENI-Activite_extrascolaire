<?php

namespace App\Controller;

use App\Entity\Participant;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MainController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/ville", name="admin_ville")
     */
    public function pageVille(EntityManagerInterface $em, UserInterface $user)
    {
        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($user->getUsername());
        $user = $participant[0];

        return $this->render('admin/ville.html.twig', [
            "user" => $user,
        ]);
    }

    /**
     * @Route("/campus", name="admin_campus")
     */
    public function pageCampus(EntityManagerInterface $em, UserInterface $user)
    {
        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($user->getUsername());
        $user = $participant[0];

        return $this->render('admin/campus.html.twig', [
            "user" => $user,
        ]);
    }
}
