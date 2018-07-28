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


    public function getAllComments()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult();
    }

    public function countAllComments()
    {
        $nb = $this
            ->createQueryBuilder('c')
            ->select('count(c) as nb')
            ->getQuery()
            ->getSingleScalarResult();
            return $nb;
    }

// METHODE OK QUI COMPTE LE NOMBRE DE COMMENTAIRES D UN SPOT
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
// METHODE QUI RECUPERE LE CONTENU DES MESSAGES D UN SPOT
    public function recupCommentsBySpot($spotId)
    {
        $rq = $this
            ->createQueryBuilder('c')
            ->select('c.message')
            ->where('c.spot = :spotId')
            //   ->orderBy('c.date', 'ASC')
            ->setParameter('spotId', $spotId)
            ->getQuery()
            ->getScalarResult();
        return $rq;
    }

    public function commentIsReport()
    {
        $rq = $this
            ->createQueryBuilder('c')
            ->select('c')
            ->where('c.report = 1')
            ->getQuery()
            ->getSingleResult();
        return $rq;
    }

//    /**
//     * @return Comment[] Returns an array of Comment objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

