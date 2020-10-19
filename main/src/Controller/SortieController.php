<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\SortieAddType;
use App\Form\SortieType;
use App\Form\SortieUpdateType;
use App\Form\SortieViewType;
use App\Model\SortieFormulaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

/**
 * Class MainController
 * @package App\Controller
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route ("/view/{id}", name="sortie_view")
     */
    public function showSortie(Request $request,EntityManagerInterface $em, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        /* Création du model */
        $sortieFormulaire = new SortieFormulaire();
        $sortieFormulaire->setNom($sortie->getNom());
        $sortieFormulaire->setDateSortie($sortie->getDateHeureDebut());
        $sortieFormulaire->setDateLimite($sortie->getDateLimiteInscription());
        $sortieFormulaire->setNombrePlace($sortie->getNbInscriptionMax());
        $sortieFormulaire->setDuree($sortie->getDuree());
        $sortieFormulaire->setDescription($sortie->getInfosSortie());
        $sortieFormulaire->setCampus($sortie->getCampus()->getNom());
        $sortieFormulaire->setVille($sortie->getLieu()->getVille()->getNom());
        $sortieFormulaire->setLieu($sortie->getLieu()->getNom());
        $sortieFormulaire->setRue($sortie->getLieu()->getRue());
        $sortieFormulaire->setCodePostal($sortie->getLieu()->getVille()->getCodePostal());
        $sortieFormulaire->setLatitude($sortie->getLieu()->getLatitude());
        $sortieFormulaire->setLongitude($sortie->getLieu()->getLongitude());

        $sortieForm = $this->createForm(SortieType::class, $sortieFormulaire, ['mode' => 'view']);
        $sortieForm->handleRequest($request);

        return $this->render('sortie/sortie.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "sortie" => $sortie,
        ]);
    }

    /**
     * @Route("/add", name="sortie_add")
     */
    public function addSortie(Request $request, EntityManagerInterface $em, UserInterface $user){
        $sortie = new Sortie();

        /* Utilisateur connecté */
        $participantRepo = $em->getRepository(Participant::class);
        $participant = $participantRepo->findByUsername($user->getUsername());
        $organisateur = $participant[0];

        /* Liste de ville */
        $villeRepo = $em->getRepository(Ville::class);
        $villes = $villeRepo->findAll();

        /* Liste de lieu */
        $lieuRepo = $em->getRepository(Lieu::class);
        $lieux = $lieuRepo->findByVille($villes[0]->getId());

        /* Campus */
        $campus = $organisateur->getCampus();


        /* Création du model */
        $sortieFormulaire = new SortieFormulaire();
        $sortieFormulaire->setCampus($participant[0]->getCampus()->getNom());


        $sortieForm = $this->createForm(SortieType::class, $sortieFormulaire, ['mode' => 'add']);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            /* Récupération Lieu */
            $lieu = $lieuRepo->findByNom($request->get('lieu'));

            /* préparation de sortie avant flush */
            $sortie->setNom($sortieForm->get('nom')->getViewData());
            $sortie->setDateHeureDebut($sortieForm->get('dateSortie')->getData());
            $sortie->setDateLimiteInscription($sortieForm->get('dateLimite')->getData());
            $sortie->setNbInscriptionMax($sortieForm->get('nombrePlace')->getData());
            $sortie->setDuree($sortieForm->get('duree')->getData());
            $sortie->setInfosSortie($sortieForm->get('description')->getViewData());
            $sortie->setCampus($campus);
            $sortie->setLieu($lieu);
            $sortie->setOrganisateur($organisateur);



            if ($sortieForm->get('enregistrer')->isClicked()){
                /* Définition état */
                $etat = $em->getRepository(Etat::class)->find(1);
                $sortie->setEtat($etat);
            }else if ($sortieForm->get('publier')->isClicked()){
                /* Définition état */
                $etat = $em->getRepository(Etat::class)->find(2);
                $sortie->setEtat($etat);
                $sortie->addParticipant($organisateur);
            }else if($sortieForm->get('annuler')->isClicked()){
                return $this->redirectToRoute('home');
            }

            $em->persist($sortie);
            $em->flush();
        }

        return $this->render('sortie/addSortie.html.twig',[
            "sortieForm" => $sortieForm->createView(),
            "villes" => $villes,
            "lieux" => $lieux,
            "lieu" => $lieux[0],
            "campus" => $campus
        ]);
    }

    /**
     * @Route ("/update/{id}", name="sortie_update")
     */
    public function updateSortie(EntityManagerInterface $em,Request $request, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        $sortieForm = $this->createForm(SortieUpdateType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            if ($sortieForm->get('publier')->isClicked()) {
                return $this->publierSortie($em, $id);
            }elseif ($sortieForm->get('supprimer')->isClicked()){
                return $this->suppressionSortie($em, $id);
            }

            $em->persist($sortie);
            $em->flush();
        }

        return $this->render('sortie/updateSortie.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "sortie" => $sortie,
        ]);
    }

    /**
     * @Route ("/publier/{id}", name="sortie_publier")
     */
    public function publierSortie(EntityManagerInterface $em, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        $etatRepo = $em->getRepository(Etat::class);
        $etat = $etatRepo->findByLibelle('Ouverte');

        $sortie->setEtat($etat);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route ("/annuler/{id}", name="sortie_annuler")
     */
    public function annulerSortie(EntityManagerInterface $em, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        $etatRepo = $em->getRepository(Etat::class);
        $etat = $etatRepo->findByLibelle('Annulée');

        $sortie->setEtat($etat);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route ("/supprimer/{id}", name="sortie_delete")
     */
    public function suppressionSortie(EntityManagerInterface $em, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);


        $em->remove($sortie);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route ("/test/{id}", name="sortie_test")
     */
    public function test(EntityManagerInterface $em, Request $request, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        /* Création du model */
        $sortieFormulaire = new SortieFormulaire();
        $sortieFormulaire->setNom($sortie->getNom());
        $sortieFormulaire->setDateSortie($sortie->getDateHeureDebut());
        $sortieFormulaire->setDateLimite($sortie->getDateLimiteInscription());
        $sortieFormulaire->setNombrePlace($sortie->getNbInscriptionMax());
        $sortieFormulaire->setDuree($sortie->getDuree());
        $sortieFormulaire->setDescription($sortie->getInfosSortie());
        $sortieFormulaire->setCampus($sortie->getCampus()->getNom());
        $sortieFormulaire->setVille($sortie->getLieu()->getVille()->getNom());
        $sortieFormulaire->setLieu($sortie->getLieu()->getNom());
        $sortieFormulaire->setRue($sortie->getLieu()->getRue());
        $sortieFormulaire->setCodePostal($sortie->getLieu()->getVille()->getCodePostal());
        $sortieFormulaire->setLatitude($sortie->getLieu()->getLatitude());
        $sortieFormulaire->setLongitude($sortie->getLieu()->getLongitude());

        $sortieForm = $this->createForm(SortieType::class, $sortieFormulaire, ['mode' => 'view']);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            
        }

        return $this->render('sortie/test.html.twig', [
            "sortieForm" => $sortieForm->createView()
        ]);
    }
}
