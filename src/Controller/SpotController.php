<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SpotController extends Controller
{
    /**
     * @Route("/spot", name="spot")
     */
    public function index()
    {
        return $this->render('spot/index.html.twig', [
            'controller_name' => 'SpotController',
        ]);
    }
}
