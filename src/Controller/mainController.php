<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class mainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render("main/home.html.twig");
    }

    /**
     * @Route("/signIn", name="sign_in")
     */
    public function singIn()
    {
        return $this->render("main/signin.html.twig");
    }

    /**
     * @Route ("/signUp", name="sign_up")
     */
    public function signUp()
    {
        return $this->render("main/signup.html.twig");
    }
}