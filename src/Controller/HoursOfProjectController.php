<?php

namespace App\Controller;

use App\Entity\HoursOfProject;
use App\Form\HoursOfProjectType;
use App\Repository\HoursOfProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hours/of/project')]
class HoursOfProjectController extends AbstractController
{
    #[Route('/', name: 'app_hours_of_project_index', methods: ['GET'])]
    public function index(Request $request, HoursOfProjectRepository $hoursOfProjectRepository, UserRepository $user): Response
    {
       

        $coste = null;
        $blablacar = $hoursOfProjectRepository->group();
        $users = $user->findAll(); 
        $suma1 = array();
        foreach($users as $user1) {
           $suma1[] = $hoursOfProjectRepository->select($user1->getId());
            
           $payments[] = $hoursOfProjectRepository->selectPayment($user1->getId());
           /* print_r($suma1);*/
        }
     
     
        foreach($suma1 as $sum)
        {
        if($sum['TOTAL'] == null) {
            $sum['TOTAL'] = 0;
        }
           $X[] = ($sum['TOTAL']);
        }
        foreach($payments as $pay)
        {
            $Y[] = ($pay['TOTAL']);
        }
       /* print_r($Y);*/
     
        $p = count($X);
        /* print_r($p); */
       
        for($a = 0; $a <= $p-1; $a++)
        {
           $z[$a] = $X[$a]*$Y[$a];
           /*print_r($z[$a]);*/
        }
       
       
        $i = 0;
        $j = 0;
       
        return $this->render('hours_of_project/index.html.twig', [
            'hours_of_projects' => $hoursOfProjectRepository->group(),
             'sumas' => array($X),
             'total' => array($z),
             'i' => $i,
             'j' => $j,
             'coste' => $coste,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_hours_of_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HoursOfProject $hoursOfProject, HoursOfProjectRepository $hoursOfProjectRepository): Response
    {
        $csrf = $this->container->get('security.csrf.token_manager');
        $token = $csrf->refreshToken('');
        $form = $this->createForm(HoursOfProjectType::class, $hoursOfProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hoursOfProjectRepository->add($hoursOfProject);
            return $this->redirectToRoute('app_hours_of_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hours_of_project/edit.html.twig', [
            'hours_of_project' => $hoursOfProject,
            'form' => $form,
            'token' => $token,
        ]);
    }
}
