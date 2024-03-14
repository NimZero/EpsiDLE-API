<?php

namespace App\Controller\Admin;

use App\Entity\Anecdote;
use App\Entity\Character;
use App\Entity\Image;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EPSI DLE');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-person', User::class);
        yield MenuItem::section('Characters');
        yield MenuItem::linkToCrud('Characters', 'fas fa-id-card', Character::class);
        yield MenuItem::linkToCrud('Anecdotes', 'fas fa-message', Anecdote::class);
        yield MenuItem::linkToCrud('Photos', 'fas fa-image', Image::class);
    }
}
