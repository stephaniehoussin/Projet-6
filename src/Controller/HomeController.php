<?php

namespace App\Controller;

use App\Form\contactType;
use App\Repository\CommentRepository;
use App\Repository\OpinionRepository;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use App\Services\PageDecoratorsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/landing", name="landing")
     * @param PageDecoratorsService $pageDecoratorsService
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function landing(PageDecoratorsService $pageDecoratorsService,SpotRepository $spotRepository)
    {
        $datetime = date("d-m-Y");
        $allResult = $pageDecoratorsService->countAllData();
        $spot = $spotRepository->recupLastSpot();
        return $this->render('landing/index.html.twig',array(
            'spot' => $spot,
            'datetime' => $datetime,
            'allResult' => $allResult
        ));
    }

    /**
     * @Route("/accueil", name="accueil")
     * @param PageDecoratorsService $pageDecoratorsService
     * @param SpotRepository $spotRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(PageDecoratorsService $pageDecoratorsService,SpotRepository $spotRepository,OpinionRepository $opinionRepository)
    {
        $datetime = date("d-m-Y");
        $allResult = $pageDecoratorsService->countAllData();
        $spots = $spotRepository->allSpotsHome();
        $opinions = $opinionRepository->allOpinions();
        return $this->render('home/index.html.twig',array(
            'datetime' => $datetime,
            'spots' => $spots,
            'allResult' => $allResult,
            'opinions' => $opinions
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
