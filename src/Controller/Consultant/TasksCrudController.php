<?php

namespace App\Controller\Consultant;

use App\Entity\Tasks;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\Query;
class TasksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tasks::class;
    }
    public function createEntity(string $entityFqcn) {
       $task = new Tasks();
       $task->setName($this->getUser());
            return $task;
      
       
        }
      
        public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
        {
            $response = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
             
                $response->where('entity.name = :id');
                $response->setParameter('id', $this->getUser()->getUsername());
            
            return $response;
        }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->onlyOnIndex(),
            TextField::new('description'),
            BooleanField::new('completed'),
            DateField::new('date')
        ];
    }
    
}
