<?php

namespace App\Repository;

use App\Entity\Favoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Favoris|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favoris|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favoris[]    findAll()
 * @method Favoris[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavorisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Favoris::class);
    }


    public function countAllFavoris()
    {
        $nb = $this->createQueryBuilder('f')
            ->select('COUNT(f) as nb')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }
    public function countFavorisByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('f')
            ->select('count(f) as nb')
            ->where('f.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    public function recupFavoritesSpotsByUser($spotId)
    {
        $rq = $this
            ->createQueryBuilder('f')
            ->select('f')
            ->where('f.spot = :spotId')
            ->setParameter('spotId', $spotId)
            ->getQuery()
            ->getResult();
        return $rq;
    }

    public function countFavorisBySpot($spotId)
    {
        $nb = $this
            ->createQueryBuilder('f')
            ->select('count(f) as nb')
            ->where('f.spot = :spotId')
            ->setParameter('spotId', $spotId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }


//    /**
//     * @return Favoris[] Returns an array of Favoris objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Favoris
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
