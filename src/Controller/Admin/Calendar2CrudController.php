<?php

namespace App\Controller\Admin;

use App\Entity\Calendar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Doctrine\ORM\EntityManagerInterface;
class Calendar2CrudController extends AbstractCrudController
{
    protected EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    public static function getEntityFqcn(): string
    {
        return Calendar::class;
    }
    public function createEntity(string $entityFqcn)
    {
        $Calendar = new Calendar();
       
        $project = $this->entityManager->getRepository(Project::class);
        $projects = $project->findAll();

        foreach ( $projects as $project ) {
               
            $Calendar->setTitle($project->getNameProject());
            $Calendar->setStart($project->getStartDate());
            $Calendar->setDescription($project->getDescription());
            $Calendar->setEnd($project->getEndDate());
        }
        return $Calendar;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('projectsEvents', 'The Project'),
            TextField::new('title', 'Title')->onlyOnIndex(),
            TextField::new('description', 'Description')->onlyOnIndex(),
            DateTimeField::new('start', 'Start Date')->onlyOnIndex(),
            DateTimeField::new('end', 'End Date')->onlyOnIndex(),
            BooleanField::new('all_day', 'All Day Event?'),
            ColorField::new('background_color'),
            ColorField::new('border_color'),
            ColorField::new('text_color'),
        ];
    }
}
