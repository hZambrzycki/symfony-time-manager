<?php

namespace App\Repository;

use App\Entity\CalendarUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CalendarUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalendarUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalendarUser[]    findAll()
 * @method CalendarUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarUser::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CalendarUser $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CalendarUser $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return CalendarUser[] Returns an array of CalendarUser objects
     */
    
    public function findByExampleField($value)
    {
      
        return $this->createQueryBuilder('c')
        ->andWhere('c.description = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getResult()
    ;
        
    }
    

    
    
}
