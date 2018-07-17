<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/landing", name="landing")
     */
    public function landing()
    {
        return $this->render('landing/index.html.twig');
    }

    /**
     * @Route("/connexion", name="connexion")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion()
    {
        return $this->render('landing/connexion.html.twig');
    }

    /**
     * @Route("inscription", name="inscription")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inscription()
    {
        return $this->render('landing/inscription.html.twig');
    }

    /**
     * @Route("/home", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }
}
