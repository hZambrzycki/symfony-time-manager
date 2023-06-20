<?php

namespace App\Controller\Admin;

use App\Entity\HoursOfProject;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class HoursOfProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HoursOfProject::class;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('projectName')
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('projectName'),
            TextField::new('nameConsultant'),
            NumberField::new('nHours','Number of Hours'),
            DateTimeField::new('start', 'Start Date')->onlyOnIndex(),
            DateTimeField::new('end', 'End Date')->onlyOnIndex(),
        ];
    }
    
}
