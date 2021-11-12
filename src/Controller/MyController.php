<?php

namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyController extends AbstractController
{
    /**
     * @Route("/acuiel", name="page_acuiel")
     */
    public function acuiel()
    {
        return $this->render('user/acuiel.html.twig');
    }
    /**
     * @Route("/")
     */
    public function affiche()
    {
        return $this->redirectToRoute('blog');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function accueil()
    {
        return $this->render('user/welcome.html.twig');
    }
    /**
     * @Route("/twig")
     */
    public function twig(Environment $twig)
    {
        return new Response($twig->render('pages/welcome.html.twig'));
    }
}
