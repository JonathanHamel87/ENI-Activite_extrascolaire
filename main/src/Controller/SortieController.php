<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\SortieAddType;
use App\Form\SortieUpdateType;
use App\Form\SortieViewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        $sortieForm = $this->createForm(SortieViewType::class, $sortie, ['toto' => null]);
        $sortieForm->handleRequest($request);

        $lieuRepo = $em->getRepository(Lieu::class);
        $lieu = $lieuRepo->find($sortieForm->get('lieu')->getViewData());

        //$nomVille = $em->getRepository(Ville::class)->find($lieu->getVille());

        $participants = $sortie->getParticipants();

        dump($sortie->getLieu());



        /* Soumission formulaire */
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){

        }

        return $this->render('sortie/sortie.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "sortie" => $sortie,
        ]);
    }

    /**
     * @Route("/add", name="sortie_add")
     */
    public function addSortie(Request $request, EntityManagerInterface $em){
        $sortie = new Sortie();
        $lieu = new Lieu();

        $sortieForm = $this->createForm(SortieAddType::class);
        $sortieForm->handleRequest($request);



        /* Soumission formulaire */
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            /* Définition lieu */
            /*$lieuRepo = $em->getRepository(Lieu::class);
            $lieu = $lieuRepo->find($sortieForm->get('lieu')->getViewData());
            /*$lieu->setLatitude($sortieForm->get('latitude')->getViewData());
            $lieu->setLongitude($sortieForm->get('longitude')->getViewData());*/


            /* Définition sortie */
            /*$sortie->setNom();
            $sortie->setDateHeureDebut();
            $sortie->setDateLimiteInscription();
            $sortie->setNbInscriptionMax();
            $sortie->setDuree();
            $sortie->setInfosSortie();
            $sortie->setCampus();
            $sortie->setLieu();*/
            //dump($lieu);


            if ($sortieForm->get('publier')->isClicked()){
                dump('publier');
            }
        }

        return $this->render('sortie/addSortie.html.twig',[
            "sortieForm" => $sortieForm->createView()
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
}
