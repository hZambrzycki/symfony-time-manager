<?php

namespace App\Controller\Consultant;

use App\Entity\HoursOfProject;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\Query;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class HoursOfProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HoursOfProject::class;
    }
    protected EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    public function createEntity(string $entityFqcn) {
        $time = new \DateTime;
    $ProjectHours = new HoursOfProject();
    $ProjectHours->setNameConsultant($this->getUser());
    $ProjectHours->setCreatedAt($time);
        return $ProjectHours;
  
   
    }
  
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
         
            $response->where('entity.nameConsultant = :id');
            $response->setParameter('id', $this->getUser());
        
        return $response;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('projectName')
            ->setQueryBuilder(function ($queryBuilder) {
                $queryBuilder->where('entity.id IN (:id)');
                $queryBuilder->setParameter('id' , ($this->getUser()->getProjects()->toArray())); 
                $queryBuilder->orWhere('entity.id IN (:uwe)');
                $queryBuilder->setParameter('uwe' , ($this->getUser()->getManagers()->toArray())); 
                return $queryBuilder->getQuery()->getResult(Query::HYDRATE_ARRAY);
            }),
           
            TextField::new('nameConsultant')->onlyOnIndex(),
            NumberField::new('nHours', 'Number of Hours Today'),
            DateTimeField::new('start', 'Start Date'),
            DateTimeField::new('end', 'End Date'),
        ];
    }
    
}
