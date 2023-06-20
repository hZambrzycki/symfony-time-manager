<?php

namespace App\Repository;

use App\Entity\HoursOfProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HoursOfProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method HoursOfProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method HoursOfProject[]    findAll()
 * @method HoursOfProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoursOfProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HoursOfProject::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(HoursOfProject $entity, bool $flush = true): void
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
    public function remove(HoursOfProject $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findByExampleField($value)
    {
        $time = new \DateTime();
        $qb = $this->createQueryBuilder('h')
            ->select('SUM(h.nHours) as totalHours')
            ->andWhere('h.nameConsultant = :val')
            ->setParameter('val', $value)
            ->andWhere('h.createdAt = :today')
            ->setParameter('today', $time->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();
          
          return $qb;
    }
    
    public function group() 
    {
        return  $this->createQueryBuilder('h')
        ->groupBy('h.nameConsultant')
        ->getQuery()
        ->getResult();
      
    }
    public function select($value)
    {
        return $this->createQueryBuilder('h')
        ->select('sum(h.nHours) as TOTAL')
        ->where('h.nameConsultant = :val')
        ->setParameter('val', $value)
        ->groupBy('h.nameConsultant')
        ->getQuery()
        ->getOneOrNullResult();
    }
    public function selectPayment($value)
    {
        return $this->createQueryBuilder('h')
        ->select('(h.paymentPerHour) as TOTAL')
        ->where('h.nameConsultant = :val')
        ->setParameter('val', $value)
        ->groupBy('h.nameConsultant')
        ->getQuery()
        ->getOneOrNullResult();
    }
    /*
    public function findOneBySomeField($value): ?HoursOfProject
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
