<?php

namespace App\Controller;

use App\Form\contactType;
use App\Repository\SpotRepository;
use App\Services\PageDecoratorsService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function home(PageDecoratorsService $pageDecoratorsService,SpotRepository $spotRepository)
    {
        $datetime = date("d-m-Y");
        $allResult = $pageDecoratorsService->countAllData();
        $spots = $spotRepository->allSpotsHome();
        return $this->render('home/index.html.twig',array(
            'datetime' => $datetime,
            'spots' => $spots,
            'allResult' => $allResult,
        ));
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(contactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('success', 'Merci pour votre message, nous allons y répondre très vite');
        }
        return $this->render('landing/contact.html.twig',[
            'contact' => $form->createView(),
            'user' => $user
        ]);

    }

    /**
     * @Route("/faq", name="faq")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function faq()
    {
        $user = $this->getUser();
        return $this->render('landing/faq.html.twig',array(
            'user' => $user
        ));
    }

    /**
     * @Route("/legalNotice", name="legalNotice")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function legalNotice()
    {
        $user = $this->getUser();
        return $this->render('landing/legalNotice.html.twig',array(
            'user' => $user
        ));
    }

    /**
     * @Route("termsOfService", name="termsOfService")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function termsOfService()
    {
        $user = $this->getUser();
        return $this->render('landing/termsOfService.html.twig',array(
            'user' => $user
        ));
    }
}
