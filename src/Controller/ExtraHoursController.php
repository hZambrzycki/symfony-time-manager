<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserAskingForExtraHours;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserExtraHoursFormType;
use App\Repository\UserAskingForExtraHoursRepository;
class ExtraHoursController extends AbstractController
{
    #[Route('/extra-hours', name: 'app_extra_hours')]
    public function index(Request $request , UserAskingForExtraHoursRepository $extraHours, EntityManagerInterface $entityManager): Response
    {
        $csrf = $this->container->get('security.csrf.token_manager');
        $token = $csrf->refreshToken('');
        $user = new UserAskingForExtraHours();
        $time = new \DateTime();
      
        $form = $this->createForm(UserExtraHoursFormType::class, new UserAskingForExtraHours());
        $form->handleRequest($request);
      
        if($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();
            $user->setUser($this->getUser());
            $user->setCreatedAt($time);
            $user->setGranted(false);
            
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('consultant');
        }
        return $this->render('extra_hours/index.html.twig', ['token' => $token,'extraHoursForm' => $form->createView()]);
    }
}
