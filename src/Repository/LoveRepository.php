<?php

namespace App\Repository;

use App\Entity\Love;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Love|null find($id, $lockMode = null, $lockVersion = null)
 * @method Love|null findOneBy(array $criteria, array $orderBy = null)
 * @method Love[]    findAll()
 * @method Love[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoveRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Love::class);
    }

    public function countAllLoves()
    {
        $nb = $this->createQueryBuilder('l')
            ->select('COUNT(l) as nb')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }
// methode qui compte le nombre de likes d'un spot
    public function countLovesBySpot($spotId)
    {
        $nb = $this
            ->createQueryBuilder('l')
            ->select('count(l) as nb')
            ->where('l.spot = :spotId')
            ->setParameter('spotId', $spotId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

//    /**
//     * @return Love[] Returns an array of Love objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Love
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
