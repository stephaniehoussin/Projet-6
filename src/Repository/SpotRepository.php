<?php

namespace App\Repository;

use App\Entity\Spot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Spot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spot[]    findAll()
 * @method Spot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Spot::class);

    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function recupLastSpot()
    {
        return  $this
            ->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllSpotsByUser($userId)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.date', 'DESC')
            ->where('u.user = :userId')
            ->setParameter('userId', $userId)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();


    }

    public function allSpotsHome()
    {
        $rq = $this->createQueryBuilder('s')
            ->select('s')
            ->orderBy('s.date', 'DESC')
            ->setMaxResults(6);
        return $rq->getQuery()->getResult();
    }

//    /**
//     * @return Spot[] Returns an array of Spot objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Spot
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
