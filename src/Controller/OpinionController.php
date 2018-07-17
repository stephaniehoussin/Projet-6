<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OpinionController extends Controller
{
    /**
     * @Route("/opinion", name="opinion")
     */
    public function index()
    {
        return $this->render('opinion/index.html.twig', [
            'controller_name' => 'OpinionController',
        ]);
    }
}
