<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Services\NewsletterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class NewsletterController extends Controller
{
    /**
     * @Route("newsletter", name="newsletter")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param NewsletterService $newsletterService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newsletter(Request $request,EntityManagerInterface $entityManager, NewsletterService $newsletterService, ValidatorInterface $validator):Response
    {
        $success = false;
        $newsletter = new Newsletter();
        $formNewsletter = $this->createForm(NewsletterType::class, $newsletter);
        $formNewsletter->handleRequest($request);
        if ($formNewsletter->isSubmitted() && $formNewsletter->isValid())
        {
                $entityManager->persist($newsletter);
                $newsletterService->newsletterSend($newsletter);
                $entityManager->flush();
                $success = true;

        //    return $this->redirectToRoute('landing');
        }
        return $this->render('newsletter/index.html.twig',array(
            'formNewsletter' => $formNewsletter->createView(),
            'success' => $success
        ));
    }
}
