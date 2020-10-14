<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\SortieAddType;
use App\Form\SortieViewType;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @Route ("/{id}", name="sortie_view")
     */
    public function showSortie(Request $request,EntityManagerInterface $em, $id){

        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        $sortieForm = $this->createForm(SortieViewType::class, $sortie);
        $sortieForm->handleRequest($request);

        $lieuRepo = $em->getRepository(Lieu::class);
        $lieu = $lieuRepo->find($sortieForm->get('lieu')->getViewData());

        $nomVille = $em->getRepository(Ville::class)->find($lieu->getVille());

        //$participants = $sortie->getParticipants();
        $participants = new ArrayCollection();

        $sorties = $sortieRepo->findAll();
        dump($sorties);

        /* Soumission formulaire */
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){

        }

        return $this->render('sortie/sortie.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "lieu" => $lieu,
            "ville" => $nomVille,
            "participants" => $participants
        ]);
    }

    /**
     * @Route("/add", name="sortie_add")
     */
    public function addSortie(Request $request){
        $sortieForm = $this->createForm(SortieAddType::class);
        $sortieForm->handleRequest($request);

        /* Soumission formulaire */
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){

        }

        return $this->render('sortie/addSortie.html.twig',[
            "sortieForm" => $sortieForm->createView()
        ]);
    }

    /**
     * @Route ("/update/{id}", name="sortie_update")
     */
    public function updateSortie(EntityManagerInterface $em, $id){
        $sortieRepo = $em->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        return $this->render('sortie/updateSortie.html.twig');
    }
}
