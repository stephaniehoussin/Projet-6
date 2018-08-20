<?php

namespace App\Repository;

use App\Entity\Favorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Favorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorite[]    findAll()
 * @method Favorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Favorite::class);
    }

   // Recup le nombre total de spots mis en favoris
    public function countAllFavoris()
    {
        $nb = $this->createQueryBuilder('f')
            ->select('COUNT(f) as nb')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // Recup le nombre total de favoris par spot
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

    // Recup du nombre total de spots mis en favoris par User
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

    // Recup les spots mis en favoris par User
    public function recupFavoritesSpotsByUser($userId)
    {
        $rq = $this
            ->createQueryBuilder('f')
            ->select('f')
            ->where('f.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
        return $rq;
    }

}
