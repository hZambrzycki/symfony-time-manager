<?php

namespace App\Controller\Consultant;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Justify;
use App\Entity\Tasks;
use App\Controller\CalendarController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\HoursOfProject;
class ConsultantDashboardController extends AbstractDashboardController
{
    #[Route('/consultant', name: 'consultant')]
    public function index(): Response
    {
        return $this->render('consultant/index.html.twig');

          }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TMP Consultory Consultant Functions');
    }
    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Main');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Calendar');
        yield MenuItem::linkToRoute('Calendar Of Projects', 'fa fa-book', 'app_calendarUsers');
        yield MenuItem::section('User Services');
        yield MenuItem::linkToCrud('Assign Hours to Project', 'fa fa-hourglass', HoursOfProject::class)
        ->setController(HoursOfProjectCrudController::class);
        yield MenuItem::linkToCrud('Justify Faults', 'fa fa-thermometer-three-quarters', Justify::class)->setController(JustifyCrudController::class);
        yield MenuItem::linkToCrud('My Tasks', 'fa fa-book', Tasks::class)->setController(TasksCrudController::class);
        
    }
}
