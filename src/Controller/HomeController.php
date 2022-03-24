<?php

namespace App\Controller;

use App\Entity\Run;
use App\Entity\Serie;
use App\Form\RunType;
use App\Form\SerieType;
use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/create-exercice", name="create_exercice")
     */
    public function createExercice(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $exercice = new Exercice();

        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercice
                ->setUser($user)
                ->setBreak(0)
                ->setStop(false)
            ;

            $manager->persist($exercice);
            $manager->flush();

            if ($exercice->getIsRun())
                return $this->redirectToRoute(
                    "create_run",
                    [
                        'id' => $exercice->getId()
                    ]
                );
            else
                return $this->redirectToRoute(
                    "create_serie",
                    [
                        'id' => $exercice->getId()
                    ]
                );
        }

        return $this->render(
            "/home/createExercice.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/create-run/{id<\d+>}", name="create_run")
     */
    public function createRun(Exercice $exercice, Request $request, EntityManagerInterface $manager)
    {
        $run = new Run();

        $form = $this->createForm(RunType::class, $run);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $run
                ->setExercice($exercice)
            ;

            $manager->persist($run);
            $manager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render(
            "/home/createRun.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/create-serie/{id<\d+>}", name="create_serie")
     */
    public function createSerie(Exercice $exercice, Request $request, EntityManagerInterface $manager)
    {
        $serie = new Serie();

        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serie
                ->setExercice($exercice)
            ;

            $manager->persist($serie);
            $manager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render(
            "/home/createSerie.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/validate-serie-or-run/{id<\d+>}", name="validate_serie")
     * @Route("/validate-serie-or-run/{id<\d+>}/{km}/{positiveElevation}", name="validate_run")
     */
    public function validateSerieOrRun(Exercice $exercice, EntityManagerInterface $manager, $km = null, $positiveElevation = null)
    {
        if ($exercice->getIsRun())
        {
            $presentRun = new Run();
            $presentRun
                ->setExercice($exercice) // griser validation si pas rempli ...
                ->setKm($km) // ... ou si score pas suffisant
                ->setPositiveElevation($positiveElevation)
            ;
            $manager->persist($presentRun);
            $manager->flush();
        }
        else
        {
            $lastSerie = $exercice->getLastTime();
            $nextRepetitions = $lastSerie->getNext();
            $nextSerie = new Serie();
            $nextSerie
                ->setExercice($exercice)
                ->setRepetitions($nextRepetitions)
            ;
            $manager->persist($nextSerie);
            $manager->flush();
        }
        return $this->redirectToRoute("home");
    }
}
