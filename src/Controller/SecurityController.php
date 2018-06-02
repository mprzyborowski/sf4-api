<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{

    public function indexAction()
    {
        return new Response(2+2);
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
    }


}