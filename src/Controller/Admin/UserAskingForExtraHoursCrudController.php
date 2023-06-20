<?php

namespace App\Controller\Admin;

use App\Entity\UserAskingForExtraHours;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use  EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
class UserAskingForExtraHoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAskingForExtraHours::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
    return $filters
        ->add('createdAt')
    ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('user')->onlyOnIndex(),
            DateField::new('createdAt')->onlyOnIndex(),
            TextField::new('description')->OnlyOnIndex(),
            BooleanField::new('granted'),
        ];
    }
    
}
