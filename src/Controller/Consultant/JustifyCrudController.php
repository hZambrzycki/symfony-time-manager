<?php

namespace App\Controller\Consultant;

use App\Entity\Justify;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
class JustifyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Justify::class;
    }
    public function createEntity(string $entityFqcn)
    {
        $Justify = new Justify();
        $Justify->setUsername($this->getUser());

        return $Justify;
    }
 
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
         
            $response->where('entity.username = :id');
            $response->setParameter('id', $this->getUser()->getUsername());
        

        return $response;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username', 'Username')->onlyOnindex(),
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
