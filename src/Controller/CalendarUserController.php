<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendarRepository;
use App\Entity\HoursOfProject;
use App\Repository\HoursOfProjectRepository;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use App\Form\HoursFormType;
use App\Repository\BackgroundEventsConsultantsRepository;
use App\Entity\CalendarUser;
use App\Repository\CalendarUserRepository;
use Doctrine\ORM\QueryBuilder;
use App\Entity\WeeksDates;
use App\Repository\WeeksDatesRepository;
use App\Repository\UserAskingForExtraHoursRepository;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
class CalendarUserController extends AbstractController
{
  protected EntityManagerInterface $entityManager;
  public function __construct(EntityManagerInterface $entityManager) {
      $this->entityManager = $entityManager;
  }
    #[Route('/calendarUsers', name: 'app_calendarUsers')]
    public function index(Request $request , EntityManagerInterface $entityManager, UserAskingForExtraHoursRepository $extraHours , CalendarUserRepository $calendar1, WeeksDatesRepository $weeks, HoursOfProjectRepository $nHours)
    {
      $csrf = $this->container->get('security.csrf.token_manager');
      $token = $csrf->refreshToken('');
      $hours = new HoursOfProject();
    
      $form = $this->createForm(HoursFormType::class, new HoursOfProject());
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
      
        
        $inicio = $_COOKIE["gfg"];
        $final =  $_COOKIE["gfg1"];
        str_replace('-','', $inicio);
        str_replace('/','', $inicio);
        str_replace('-','', $final);
        str_replace('/','', $final);
  
        $inicio1 = strtotime($inicio);
        $final1 = strtotime($final);

        
        $start = new \DateTime(date('Y-m-d', $inicio1));
        $end = new \DateTime(date('Y-m-d', $final1));
        
        $hours = $form->getData();
        $hours->setStart($start);
        $hours->setEnd($end);
        $timeStart = $hours->getStart();
        $timeEnd = $hours->getEnd();

        $interval = $timeStart->diff($timeEnd);

        $intervalInt = (int)$interval->format('%a');

       /* $time = new \DateTime("now");*/
        $calendar = new CalendarUser();

        $calendar->setTitle($hours->getProjectName());
        $calendar->setDescription($hours->getNameConsultant());
        $calendar->setStart($hours->getStart());
        $calendar->setEnd($hours->getEnd());

         for ($x = 1; $x <= $intervalInt; $x++) {
          $start11 = new \DateTime(date('Y-m-d', $inicio1));
          $start12 = new \DateTime();
          $hours1 = new HoursOfProject();
          $hours1 = $form->getData();
          $hours1->setStart($start11);
          $hours1->setEnd($end);
          $hours->setCreatedAt($start12);
          $entityManager->merge($hours1);

        }
        
        $entityManager->flush();
       
      
        $entityManager->persist($calendar);
        $entityManager->flush();
  
      }
      $events = $calendar1-> findByExampleField($this->getUser()->getUsername());

      $rdvs = [];

      foreach($events as $event){
          $rdvs[] = [
              'id' => $event->getId(),
              'start' => $event->getStart()->format('Y-m-d'),
              'end' => $event->getEnd()->format('Y-m-d'),
              'title' => $event->getTitle(),
              'description' => $event->getDescription(),

          ];
      }

      $weekss = $weeks->findAll();

      foreach($weekss as $week) {
        $dataWeeksStart[] = [
          'start' => $week->getStart()->format('Y-m-d'),
        ];
        $dataWeeksEnd[] = [
          'end' => $week->getEnd()->modify('+1 day')->format('Y-m-d'),
        ];
      }
 
      $data = json_encode($rdvs);
      $data1 = json_encode($dataWeeksStart);
      $data2 = json_encode($dataWeeksEnd);
     
     
    
  
      $resultadoQuery = $nHours->findByExampleField($this->getUser()->getId());
      
      $limite = 8;
      $bool = false;
      if($resultadoQuery['totalHours'] < 8) {
        $bool = false;
        
        return $this->render('calendar/indexUsers.html.twig',['token' => $token , 'data' => $data, 'bool' => $bool, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);

      } else if($resultadoQuery['totalHours'] > 8) {
        $horasT =  $extraHours->check($this->getUser()->getId());
   
        $bool = true;
        if($horasT['TOTAL'] == 1) {
          $bool = true;
       
        
          $horasTotales = 1;
          return $this->render('calendar/indexUsers.html.twig',['token' => $token,'data' => $data, 'bool' => $bool, 'horasT' => $horasTotales, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);
        } 
        if($horasT['TOTAL'] == 0) {
          $bool = true;
       
   
          $horasTotales = 0;
          return $this->render('calendar/indexUsers.html.twig',['token' => $token,'data' => $data, 'bool' => $bool, 'horasT' => $horasTotales, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);
        }
        if($horasT['TOTAL'] > 1) {
          $bool = true;
       
   
          $horasTotales = 1;
          return $this->render('calendar/indexUsers.html.twig',['token' => $token,'data' => $data, 'bool' => $bool, 'horasT' => $horasTotales, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);
        }
      } else {
        $horasT =  $extraHours->check($this->getUser()->getId());
        $bool = true;
        if($horasT['TOTAL'] == 1) {
          $bool = true;
       
        
          $horasTotales = 1;
          return $this->render('calendar/indexUsers.html.twig',['token' => $token,'data' => $data, 'bool' => $bool, 'horasT' => $horasTotales, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);
        } 
        if($horasT['TOTAL'] == 0) {
          $bool = true;
       
   
          $horasTotales = 0;
          return $this->render('calendar/indexUsers.html.twig',['token' => $token,'data' => $data, 'bool' => $bool, 'horasT' => $horasTotales, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);
        }
        if($horasT['TOTAL'] > 1) {
          $bool = true;
       
   
          $horasTotales = 1;
          return $this->render('calendar/indexUsers.html.twig',['token' => $token,'data' => $data, 'bool' => $bool, 'horasT' => $horasTotales, 'dataWeeksStart' => $data1, 'dataWeeksEnd' => $data2  ,'hoursForm' => $form->createView()]);
        }
      }
    
    }
}
