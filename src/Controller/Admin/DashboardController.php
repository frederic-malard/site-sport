<?php

namespace App\Controller\Admin;

use App\Entity\Run;
use App\Entity\User;
use App\Entity\Serie;
use App\Entity\Exercice;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\ExerciceCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ExerciceCrudController::class)->generateUrl());
        // return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('VersSymfSport');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Exercices', 'fas fa-heart-pulse', Exercice::class);
        // easyadmin marche pas avec single table inheritance.......
        // yield MenuItem::linkToCrud('Series', 'fas fa-dumbbell', Serie::class);
        // yield MenuItem::linkToCrud('Runs', 'fas fa-person-running', Run::class);
    }
}
