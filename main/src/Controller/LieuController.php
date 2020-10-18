<?php

namespace App\Controller;

use App\Entity\Lieu;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

/**
 * Class MainController
 * @package App\Controller
 * @Route("/lieu")
 */
class LieuController extends AbstractController
{
    /**
     * @Route("", name="lieu")
     */
    public function index()
    {
        return $this->render('lieu/index.html.twig', [
            'controller_name' => 'LieuController',
        ]);
    }

    /**
     * @Route("/recupLieu", name="lieu_create_sortie")
     */
    public function recupererLieu(EntityManagerInterface $em, Request $request){
        $lieuRepo = $em->getRepository(Lieu::class);
        $lieu = $lieuRepo->find($request->get('id'));

        $response = array(
            'rue' => $lieu->getRue(),
            'codePostal' => $lieu->getVille()->getCodePostal(),
            'latitude' => $lieu->getLatitude(),
            'longitude' => $lieu->getLongitude()
        );

        return new JsonResponse($response);
    }

    /**
     * @Route("/recupLieux", name="lieux_create_sortie")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return JsonResponse
     */
    public function recupererLieux(EntityManagerInterface $em, Request $request){
        $lieuRepo = $em->getRepository(Lieu::class);
        $lieux = $lieuRepo->findByVille($request->get('id'));


        $response = array();
        foreach ($lieux as $lieu){
            dump($lieu);
            $temp = array(
                'id' => $lieu->getId(),
                'nom' => $lieu->getNom(),
                'rue' => $lieu->getRue(),
                'codePostal' => $lieu->getVille()->getCodePostal(),
                'latitude' => $lieu->getLatitude(),
                'longitude' => $lieu->getLongitude()
            );
            array_push($response, $temp);
        }
        return new JsonResponse($response);
    }
}
