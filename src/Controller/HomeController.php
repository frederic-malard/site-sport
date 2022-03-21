<?php

namespace App\Controller;

use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        if ($this->isGranted('ROLE_USER'))
        {
            $exercices = $this->getUser()->getExercices()->getValues();
            return $this->render(
                'home/index.html.twig',
                [
                    'exercices' => $exercices
                ]
            );
        }
        else
            return $this->redirectToRoute('about');
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('home/about.html.twig');
    }
}
