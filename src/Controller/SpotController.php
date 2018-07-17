<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SpotController extends Controller
{
    /**
     * @Route("/make_spot", name="make_spot")
     */
    public function makeSpot()
    {
        return $this->render('spot/makeSpot.html.twig');
    }
    /**
     * @Route("/search_spot", name="search_spot")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchSpot()
    {
        return $this->render('spot/searchSpot.html.twig');
    }

}
