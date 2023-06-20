<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use  EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

        ->setSearchFields(['username'])
        ->setPaginatorPageSize(20);
        
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('username')
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username', 'Username'),
            ArrayField::new('roles', 'Roles'),
        ];
    }
}
