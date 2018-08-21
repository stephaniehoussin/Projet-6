<?php

namespace App\Repository;

use App\Entity\Reject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reject|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reject|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reject[]    findAll()
 * @method Reject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RejectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reject::class);
    }

    public function recupReasonReject($spotId)
    {
        $rq = $this->createQueryBuilder('r')
            ->select('r')
            ->where('r.spot = :spotId')
            ->setParameter('spotId',$spotId)
            ->getQuery()
            ->getResult();
        return $rq;
    }


//    /**
//     * @return Reject[] Returns an array of Reject objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reject
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
