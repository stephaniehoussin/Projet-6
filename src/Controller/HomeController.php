<?php

namespace App\Controller;

use App\Form\contactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

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
     * @Route("/game", name="game")
     */
    public function game()
    {
        return $this->render('landing/game.html.twig');
    }

    /**
     * @Route("/accueil", name="accueil")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(contactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('success', 'Merci pour votre message, nous allons y répondre très vite');
        }
        return $this->render('home/contact.html.twig',[
            'contact' => $form->createView(),
        ]);

    }
}
