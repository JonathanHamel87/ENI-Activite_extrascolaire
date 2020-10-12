<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class MainController
 * @package App\Controller
 * @Route("/")
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


        return $this->render("main/home.html.twig", [
            "campus" => $campus,
            "date" => $date,
            "user" => $user,
            "sorties" => $sorties
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request, SluggerInterface $slugger, EntityManagerInterface $em, UserInterface $user, UserPasswordEncoderInterface $encoder){

        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($user->getUsername());
        $user = $participant[0];
        $source = 'uploads/img/'.$user->getId().'.jpeg';


        /* Formulaire profil */
        $profilForm = $this->createForm(ProfilType::class, $user);
        $profilForm->handleRequest($request);
        if ($profilForm->isSubmitted() && $profilForm->isValid())
        {
            $photo = $profilForm->get('photo')->getData();

            if ($photo){
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $user->getId().'.'.$photo->guessExtension();

                try {
                    $photo->move(
                        $this->getParameter('upload_files'),
                        $newFilename
                    );
                } catch (FileException $exception) {

                }

                $user->setFile($newFilename);
            }

            if ($profilForm->get('password')->getData() != null){
                $hashed = $encoder->encodePassword($user, $profilForm->get('password')->getData());
                $user->setPassword($hashed);
            }

            $em->persist($user);
            $em->flush();

        }

        return $this->render('main/profil.html.twig',[
            "profilForm" => $profilForm->createView(),
            "source" => $source
        ]);






        $error=false;


        if($photo != null && !in_array(strtolower($photo->getClientOriginalExtension()),
                $this->getParameter('media_extension_photo'))){

            $formMonProfil->get('fileTemp')->addError(
                new FormError('La photo n\'est pas au bon format : '. implode(', ', $this->getParameter('media_extension_photo'))));
            $error = true;
        }

        if(!$error){
            if(!empty($formMonProfil->get('passwordPlain')->getData())) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $formMonProfil->get('passwordPlain')->getData()
                    )
                );
            }



            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre profil a été modifié avec succès!' );
            //return $this->redirectToRoute('profil');
        }else{
            $this->addFlash('warning', 'Une erreur est arrivée' );
        }
    }
}
