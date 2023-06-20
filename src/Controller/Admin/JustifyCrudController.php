<?php

namespace App\Controller\Admin;

use App\Entity\Justify;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
class JustifyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Justify::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username', 'Username'),
            TextField::new('description', 'Description'),
            DateTimeField::new('date', 'Date'),
            ImageField::new('image', 'Justificante')
            ->setBasePath('images/user')
            ->setUploadDir('public/images/user')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
        ];
    }
}
