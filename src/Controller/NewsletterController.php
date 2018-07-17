<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsletterController extends Controller
{
    /**
     * @Route("/newsletter", name="newsletter")
     */
    public function index()
    {
        return $this->render('newsletter/index.html.twig', [
            'controller_name' => 'NewsletterController',
        ]);
    }
}
