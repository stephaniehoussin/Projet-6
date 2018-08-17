<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    // Recup le nombre total de commentaires
    public function countAllComments()
    {
        $nb = $this
            ->createQueryBuilder('c')
            ->select('count(c) as nb')
            ->getQuery()
            ->getSingleScalarResult();
            return $nb;
    }

    // Recup le nombre total de commentaires par spot
    public function countCommentsBySpot($spotId)
    {
        $nb = $this
            ->createQueryBuilder('c')
            ->select('count(c) as nb')
            ->where('c.spot = :spotId')
            ->setParameter('spotId', $spotId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // Recup le nombre de commentaires par User
    public function countCommentsByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('c')
            ->select('count(c) as nb')
            ->where('c.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // Recup tous les commentaires d'un spot
    // NE SERT NUL PART POUR LE MOMENT
    public function recupCommentsBySpot($spotId)
    {
        $rq = $this
            ->createQueryBuilder('c')
            ->select('c.message')
            ->where('c.spot = :spotId')
            ->orderBy('c.date', 'DESC')
            ->setParameter('spotId', $spotId)
            ->getQuery()
            ->getScalarResult();
        return $rq;
    }




    // Recup le nombre de commentaires signalés par User
    public function countCommentIsReportByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('c')
            ->select('count(c) as nb')
            ->where('c.user = :userId')
            ->andWhere('c.report = 1')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // Recup le nombre total de commentaires signalés à traiter
    public function countCommentsIsReport()
    {
        $nb = $this
            ->createQueryBuilder('c')
            ->select('count(c) as nb')
            ->where('c.report = 1')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }
    // Recup les commentaires qui sont signalés
    public function recupCommentIsReport()
    {
        $rq = $this
            ->createQueryBuilder('c')
            ->select('c')
            ->where('c.report = 1')
            ->getQuery()
            ->getResult();
        return $rq;
    }

    // Recup les commentaires qui sont signalés par user
    public function recupCommentIsReportByUSer($userId)
    {
        $rq = $this
            ->createQueryBuilder('c')
            ->select('c')
            ->orderBy('c.date', 'DESC')
            ->where('c.user = :userId')
            ->AndWhere('c.report = 1')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
        return $rq;
    }


}

