<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Spot;
use App\Form\contactType;
use App\Repository\CommentRepository;
use App\Repository\OpinionRepository;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class HomeController extends Controller
{
    /**
     * @Route("/landing", name="landing")
     * @param SpotRepository $spotRepository
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function landing(SpotRepository $spotRepository,CommentRepository $commentRepository,Request $request,UserRepository $userRepository, OpinionRepository $opinionRepository)
    {
        $datetime = date("d-m-Y");
        $totalNbComments = $commentRepository->countAllComments();
        $totalNbSpots = $spotRepository->countAllSpots();
        $totalNbUsers = $userRepository->countAllUsers();
        $totalNbOpinions = $opinionRepository->countAllOpinions();
        $spot = $spotRepository->recupLastSpot();
        return $this->render('landing/index.html.twig',array(
            'totalNbComments' => $totalNbComments,
            'spot' => $spot,
            'datetime' => $datetime,
            'totalNbSpots' => $totalNbSpots,
            'totalNbUsers' => $totalNbUsers,
            'totalNbOpinions' => $totalNbOpinions
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
     * @param SpotRepository $spotRepository
     * @param CommentRepository $commentRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(SpotRepository $spotRepository,CommentRepository $commentRepository,UserRepository $userRepository,OpinionRepository $opinionRepository)
    {
        //$spots = $spotRepository->findAll();
        $datetime = date("d-m-Y");
        $totalNbComments = $commentRepository->countAllComments();
        $totalNbSpots = $spotRepository->countAllSpots();
        $totalNbUsers = $userRepository->countAllUsers();
        $totalNbOpinions = $opinionRepository->countAllOpinions();
        $spots = $spotRepository->allSpotsHome();
        return $this->render('home/index.html.twig',array(
            'totalNbComments' => $totalNbComments,
            'datetime' => $datetime,
            'spots' => $spots,
            'totalNbSpots' => $totalNbSpots,
            'totalNbUsers' => $totalNbUsers,
            'totalNbOpinions' => $totalNbOpinions
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
