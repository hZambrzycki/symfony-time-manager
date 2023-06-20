<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ->setSearchFields(['nameproject'])
            ->setPaginatorPageSize(20);
    
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nameproject', 'Name of the Project'),
            TextField::new('description', 'Description of the Project'),
            DateTimeField::new('startdate', 'Start Date'),
            DateTimeField::new('enddate', 'End Date'), 

        ];
    }
    
}
