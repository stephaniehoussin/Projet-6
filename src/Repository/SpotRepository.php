<?php

namespace App\Repository;

use App\Entity\Spot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    // RECUPERATION DU DERNIER SPOT
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
   // RECUPERATION DE TOUS LES SPOTS PAR USER
    public function findValidedSpotsByUser($userId)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.date', 'DESC')
            ->where('u.user = :userId')
            ->andWhere('u.status = 2')
            ->setParameter('userId', $userId)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }

    public function findWaitingSpotsByUser($userId)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.date', 'DESC')
            ->where('u.user = :userId')
            ->andWhere('u.status = 1')
            ->setParameter('userId', $userId)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }


  // RECUPERATION DE TOUS LES SPOTS PAR DATE ET PAR PAGE
    public function findAllSpotsByDate($page)
    {

        if (!is_numeric($page)) {
            throw new InvalidArgumentException("La page que vous souhaitez atteindre ne semble pas valide");
        }

        if($page < 1)
        {
            throw new NotFoundHttpException("Désolé la page souhaitée n'existe pas");
        }
        $rq = $this->createQueryBuilder('s')
            ->select('s')
            ->orderBy('s.date', 'DESC')
            ->setMaxResults(12)
            ->setFirstResult($page * 12 - 12);
        return $rq->getQuery()->getResult();
    }

    // RECUPERATION DE 6 SPOTS POUR PAGE ACCUEIL
    public function allSpotsHome()
    {
        $rq = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.status = 2')
            ->orderBy('s.date', 'DESC')
            ->setMaxResults(6);
        return $rq->getQuery()->getResult();
    }

    // RECUPERATIONS DE SPOTS PAR TITRE
    public function findSpotByTitle($term)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where($qb->expr()->like('s.title', ':title'))
            ->setParameter("title", "%$term%")
            ->setMaxResults(20);

        return $qb->getQuery()->getResult();
    }

    // COMPTEUR DE TOUS LES SPOTS
    public function countAllSpots()
    {
        $nb = $this->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // COMPTEUR DE TOUS LES SPOTS PAR USER
    public function countSpotsByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->where('s.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // RECUPERE TOUS LES SPOTS EN ATTENTE DE VALIDATION
    public function findSpotsByWaitingStatus()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.status = 1')
            ->orderBy('s.date', 'ASC');
        return $qb->getQuery()->getResult();

    }

    public function countSpotsByWaitingStatus()
    {
        $nb = $this
            ->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->where('s.status = 1')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    public function countSpotsValidatedByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->where('s.status = 2')
            ->andWhere('s.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    public function countSpotsWaitingByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->where('s.status = 1')
            ->andWhere('s.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

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
