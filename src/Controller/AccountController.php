<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('account/profile.html.twig');
    }
}
