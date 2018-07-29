<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Spot;
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
    public function landing(Request $request, EntityManagerInterface $entityManager)
    {
        $datetime = date("d-m-Y");
        $em = $this->getDoctrine()->getManager();
        $totalNbComments = $em->getRepository(Comment::class)->countAllComments();
        $spot = $em->getRepository(Spot::class)->recupLastSpot();
        return $this->render('landing/index.html.twig',array(
            'totalNbComments' => $totalNbComments,
            'spot' => $spot,
            'datetime' => $datetime
        ));
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
        $em = $this->getDoctrine()->getManager();
        $spots = $em->getRepository(Spot::class)->findAll();
        $datetime = date("d-m-Y");
        $em = $this->getDoctrine()->getManager();
        $totalNbComments = $em->getRepository(Comment::class)->countAllComments();
        $spots = $em->getRepository(Spot::class)->allSpotsHome();
        return $this->render('home/index.html.twig',array(
            'totalNbComments' => $totalNbComments,
            'datetime' => $datetime,
            'spots' => $spots
        ));
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
