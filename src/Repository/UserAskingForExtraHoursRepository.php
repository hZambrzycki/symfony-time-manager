<?php

namespace App\Repository;

use App\Entity\UserAskingForExtraHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAskingForExtraHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAskingForExtraHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAskingForExtraHours[]    findAll()
 * @method UserAskingForExtraHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAskingForExtraHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAskingForExtraHours::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserAskingForExtraHours $entity, bool $flush = true): void
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
    public function remove(UserAskingForExtraHours $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function counter() 
    {
        $time = new \DateTime();
        

         return $this->createQueryBuilder('h')
        ->select('count(h.id) AS TOTAL')
        ->andWhere('h.createdAt = :val')
        ->setParameter('val', $time->format('Y-m-d'))
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function check($value)
    {
        $time = new \DateTime;
        $granted = 1;
        return $this->createQueryBuilder('h')
        ->select('count(h.id) AS TOTAL')
        ->andWhere('h.createdAt = :val')
        ->SetParameter('val', $time->format('Y-m-d'))
        ->andWhere('h.user = :id')
        ->SetParameter('id', $value)
        ->andWhere('h.granted = :s')
        ->SetParameter('s', 1)
        ->getQuery()
        ->getOneOrNullResult();
    }

    // /**
    //  * @return UserAskingForExtraHours[] Returns an array of UserAskingForExtraHours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAskingForExtraHours
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
