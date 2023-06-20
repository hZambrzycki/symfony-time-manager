<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Entity\User;
use App\Form\ProjectManagmentFormType;
use App\Form\ProjectMemberFormType;
class Project2CrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nameproject', 'Name of the Project')
            ->onlyOnIndex(),
            AssociationField::new('managersOfTheProject', 'Manager  of the Project'),
            AssociationField::new('membersOfTheProject', 'Members of the Project'),
           
            
        ];
    }
}
