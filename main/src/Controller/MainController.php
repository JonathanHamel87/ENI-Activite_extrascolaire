<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\ListSortieType;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
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
    public function home(EntityManagerInterface $em, UserInterface $user, Request $request, Session $session)
    {
        $isPresent = false;

        /* Récupération de la liste des sorties */
        $sortieRepo = $em->getRepository(Sortie::class);
        $sorties = $sortieRepo->findAll();

        /* Date du jour */
        $date = new \DateTime();

        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($user->getUsername());
        $user = $participant[0];

        $session->set('userActif', $user);

        /* Formulaire listeSortie */
        $listeSortieForm = $this->createForm(ListSortieType::class);
        $listeSortieForm->handleRequest($request);


        /* Soumission formulaire */
        if ($listeSortieForm->isSubmitted() && $listeSortieForm->isValid()){
            if ($listeSortieForm->get('creerSortie')->isClicked()){
                return $this->redirectToRoute('sortie_add');
            }
            $sortieRepo = $em->getRepository(Sortie::class);

            /* Préparation des critères */
            $search = $listeSortieForm->get('nomSortie')->getViewData();
            $campusId = $listeSortieForm->get('campus')->getViewData();
            $dateDebut = $listeSortieForm->get('firstDate')->getViewData();
            $dateFin = $listeSortieForm->get('secondeDate')->getViewData();
            $organisateur = $listeSortieForm->get('bOrganisateur')->getData();
            $inscrit = $listeSortieForm->get('bInscrit')->getData();
            $nonInscrit = $listeSortieForm->get('bNonInscrit')->getData();
            $sortieFini = $listeSortieForm->get('bFini')->getData();

            $sorties = $sortieRepo->findByFilter($search, $campusId, $dateDebut, $dateFin, $organisateur, $inscrit, $nonInscrit, $sortieFini, $user->getId());

        }
        return $this->render("main/home.html.twig", [
            "date" => $date,
            "listSortieForm" => $listeSortieForm->createView(),
            "sorties" => $sorties,
            "isPresent" => $isPresent

        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request, Session $session, UserInterface $test, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){

        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($test->getUsername());
        $user = $participant[0];
        $source = 'uploads/img/'.$user->getId().'.jpeg';

        /* Formulaire profil */
        $profilForm = $this->createForm(ProfilType::class, $user);
        $profilForm->handleRequest($request);
        if ($profilForm->isSubmitted() && $profilForm->isValid())
        {
            $photo = $profilForm->get('photo')->getData();

            if ($photo){
                //$originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
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

            $session->set('userActif', $user);

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
            $em->persist($user);
            $em->flush();

            $session->set('userActif', $user);

            $this->addFlash('success', 'Votre profil a été modifié avec succès!' );
            //return $this->redirectToRoute('profil');
        }else{
            $this->addFlash('warning', 'Une erreur est arrivée' );
        }
    }

    /**
     * @Route("/profil/show/{id}", name="profil_show")
     */
    public function profilShow(Request $request, EntityManagerInterface $em, $id){

        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->find($id);

        $source = '/uploads/img/'.$participant->getId().'.jpeg';

        /* Formulaire profil */
        $profilForm = $this->createForm(ProfilType::class, $participant, ['mode' => 'show']);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted()){
            $this->redirectToRoute('home');
        }

        return $this->render('main/profilShow.html.twig',[
            "profilForm" => $profilForm->createView(),
            "source" => $source,
            "username" => $participant->getPseudo()
        ]);
    }

}
