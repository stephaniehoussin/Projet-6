<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    /**
     * @Route("/mon-compte", name="mon-compte")
     */
    public function index()
    {
        return $this->render('account/index.html.twig');
    }
}
