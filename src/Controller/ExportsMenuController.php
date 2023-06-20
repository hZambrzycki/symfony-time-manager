<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\HoursOfProjectRepository;
use App\Repository\CalendarUserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExportsMenuController extends AbstractController
{
    #[Route('/exports/menu', name: 'app_exports_menu')]
    public function index(): Response
    {
        return $this->render('exports_menu/index.html.twig', [
            'controller_name' => 'ExportsMenuController',
        ]);
    }

    #[Route('/exportpdf', name: 'app_exports_pdf')]
    public function toPDF(HoursOfProjectRepository $repository, EntityManagerInterface $entityManager) {
      
        $events = $repository->findAll();

        $data = [];
 
 
        foreach($events as $event) {
            $data =
              array($event->getProjectName(), $event->getNameConsultant(), $event->getNHours());
              $rows[] = implode(',', $data);
 
            
        }
        $content = implode("\n", $rows);
      
 
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/pdf');
    
        return $response;
        
    }
    #[Route('/exportcsv', name: 'app_csv')]
    public function toCSV(HoursOfProjectRepository $repository, EntityManagerInterface $entityManager) {

        $events = $repository->findAll();

        $data = [];
 
 
        foreach($events as $event) {
            $data =
              array($event->getProjectName(), $event->getNameConsultant(), $event->getNHours());
              $rows[] = implode(',', $data);
 
            
        }
        $content = implode("\n", $rows);
      
 
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
    
        return $response;
    }
}
