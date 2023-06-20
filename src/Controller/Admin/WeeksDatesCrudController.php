<?php

namespace App\Controller\Admin;

use App\Entity\WeeksDates;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class WeeksDatesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WeeksDates::class;
    }
    public function createEntity(string $entityFqcn)
    {
        $Week = new WeeksDates();
        date_default_timezone_set('Europe/Berlin'); 
        $time = new \DateTime("now");
        
        $Week->setDateAtTheMoment($time);
        return $Week;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('start', 'Start'),
            DateTimeField::new('end', 'End'),
            DateTimeField::new('dateAtTheMoment', 'Created At :')->onlyOnIndex(),
        ];
    }
    
}
