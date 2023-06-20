<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\CalendarController;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\Relation;
use App\Entity\Calendar;
use App\Entity\AssignProject;
use App\Entity\HoursOfTheProject;
use \Datetime;
use App\Entity\ProjectManagment;
use App\Entity\Tasks;
use App\Entity\WeeksDates;
use App;
use App\Entity\BackgroundEventsConsultants;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserAskingForExtraHours;
use App\Repository\UserAskingForExtraHoursRepository;
use App\Repository\UserRepository;
use App\Entity\Justify;
use App\Repository\JustifyRepository;

class AdminDashboardController extends AbstractDashboardController
{
    protected EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager, JustifyRepository $justify, UserRepository $user1, ProjectRepository $project, UserAskingForExtraHoursRepository $user) {
        $this->project = $project;
        $this->entityManager = $entityManager;
        $this->user = $user;
        $this->user1 = $user1;
        $this->justify = $justify;
     
    } 
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $time = new \DateTime("now");
       
        $projects = $this->project->findAll();
        $finished = $this->project->counter()['TOTAL'];
        $totalProjects = $this->project->counterTotal()['TOTAL'];
        $totalCurrentProjects = $this->project->counterValid()['TOTAL'];
        $totalUsers = $this->user1->counterTotal()['TOTAL'];
        
        foreach ($projects as $project) {    
            if(  $time > $project->getEnddate()) {
                $this->addFlash('warning', 'The project with the name '. $project->getNameproject().' has finished or will finish soon');
            }
        }               
        return $this->render('admin/index.html.twig', ['project' => $projects, 'time' => $time, 'finished' => $finished,'totalProjects' => $totalProjects, 'totalUsers' => $totalUsers, 'currentProjects' => $totalCurrentProjects] );

    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TMP Consultory Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Basic');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Exports Menu', 'fa fa-envelope-open', 'app_exports_menu');
        yield MenuItem::linkToCrud('Tasks', 'fa fa-bell-o', Tasks::class);
        yield MenuItem::section('Calendar');
        yield MenuItem::linkToRoute('Calendar', 'fa fa-book', 'app_calendar');
        yield MenuItem::linkToCrud('Create Event', 'fa fa-calendar', Calendar::class)
        ->setController(CalendarCrudController::class);
        yield MenuItem::linkToCrud('Block & Unblock Calendar', 'fa fa-calendar', WeekDates::class)
        ->setController(WeeksDatesCrudController::class);
    
        yield MenuItem::section('Projects');
        $totalProjects = ($this->project->counterAll()['TOTAL']);
        yield MenuItem::linkToRoute('Payments Of Projects','fa fa-credit-card', 'app_hours_of_project_index');
        
        yield MenuItem::linkToCrud('Create a Project', 'fa fa-database', Project::class)
        ->setController(ProjectCrudController::class)
        ->setBadge($totalProjects, 'background: transparent; color: orange; outline: 2px solid orange');
        yield MenuItem::linkToCrud('Assign to a Project', 'fas fa-project-diagram', Project::class)
        ->setController(Project2CrudController::class);
        yield MenuItem::linkToCrud('Assign Project as an Event', 'fa fa-calendar-check-o', Project::class)
        ->setController(Calendar2CrudController::class);
        $finished = ($this->project->counter()['TOTAL']);
        yield MenuItem::linkToCrud('Projects That Have Already Finished', 'fa fa-times', Project::class)
        ->setController(Project3CrudController::class)
        ->setBadge($finished, 'background: transparent; color: red; outline: 2px solid red');
        $totalCurrentProjectss = ($this->project->counterValid()['TOTAL']);
        yield MenuItem::linkToCrud('Current Projects', 'fa fa-check', Project::class)
        ->setController(Project4CrudController::class)
        ->setBadge($totalCurrentProjectss, 'background: transparent; green: red; outline: 2px solid green');
        yield MenuItem::linkToCrud('See Hours Of The Project', 'fa fa-film', HoursOfProject::class)
        ->setController(HoursOfProjectCrudController::class);
        $total = ($this->user->counter()['TOTAL']);
        yield MenuItem::linkToCrud('Extra Hours Items', 'fa fa-clock-o', UserAskingForExtraHours::class)
        ->setController(UserAskingForExtraHoursCrudController::class)
        ->setBadge($total, 'background: transparent; color: red; outline: 2px solid red');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Assign Rol To User', 'fa fa-users', User::class)
        ->setController(UserCrudController::class);
        $justificantes = ($this->justify->counter()['TOTAL']);
        yield MenuItem::linkToCrud('Documents', 'fa fa-thermometer-empty', Justify::class)
        ->setController(JustifyCrudController::class)
        ->setBadge($justificantes,  'background: transparent; green: red; outline: 2px solid green');
    }
}
