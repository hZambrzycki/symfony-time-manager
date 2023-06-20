<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Repository\HoursOfProjectRepository;
use App\Repository\CalendarUserRepository;
use Doctrine\ORM\EntityManagerInterface;
class ExcelExportController extends AbstractController
{
    protected EntityManagerInterface $entityManager;

    #[Route('/excelexport', name: 'app_excel_export')]
    public function index(HoursOfProjectRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Name Consultant !');
        $sheet->setCellValue('B1', 'Number of Hours !');
        $sheet->setCellValue('C1', 'Project !');
        $sheet->setTitle("HOURS DATA");

     
       $events = $repository->findAll();

       $rows = [];


       foreach($events as $event) {
           $data =
             array($event->getProjectName(), $event->getNameConsultant(), $event->getNHours());
             $rows[] = implode(',', $data);

           
       }
       $content = implode("\n", $rows);
     

       $sheet->setCellValue('A1', $content);

  
      
        

          
      

           // Crear tu archivo Office 2007 Excel (XLSX Formato)
           $writer = new Xlsx($spreadsheet);
        
           // Crear archivo temporal en el sistema
           $fileName = 'NumberOfHoursOfEmployees.xlsx';
           $temp_file = tempnam(sys_get_temp_dir(), $fileName);
           
           // Guardar el archivo de excel en el directorio temporal del sistema
           $writer->save($temp_file);
           
           // Retornar excel como descarga
           return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
           return $this->render('excel_export/index.html.twig', [
            'controller_name' => 'ExcelExportController',
          ]);
    }
 
}
