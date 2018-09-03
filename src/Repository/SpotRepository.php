<?php

namespace App\Repository;

use App\Entity\Spot;
use App\Entity\User;
use App\Entity\Category;
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

    // Recup des 6 derniers spots
    // page d'accueil
    public function allSpotsHome()
    {
        $rq = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.status = 2')
            ->orderBy('s.date', 'DESC')
            ->setMaxResults(6);
        return $rq->getQuery()->getResult();
    }

    // Recup de tous les spots par date et avec pagination
    // pour la page  acueil je cherche un spot
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
            ->where('s.status =2')
            ->setMaxResults(12)
            ->setFirstResult($page * 12 - 12);
        return $rq->getQuery()->getResult();
    }

    // Recup du nombre total de spots validés
    // pour stats sur site
    public function countAllSpots()
    {
        $nb = $this->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->where('s.status =2')
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }

    // Recup de tous les spots en attente de validation
    // Pour modérateur dans mon compte
    public function findSpotsByWaitingStatus()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.status = 1')
            ->orderBy('s.date', 'ASC');
        return $qb->getQuery()->getResult();

    }

    // Recup du nombre total de spot en attente de validation
    // Pour modérateur dans mon compte
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

    // Recup de tous les spots en attente par User
    // Pour user dans mon compte
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


    // Recup du nombre total de spots en attente par user
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


    // Recup de tous les spots validés par User
    //Pour user et modérateur dans mon compte
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

    // recup spots par user et par category
    public function findSpotsByUserAndCategory(User $user = null, Category $category =null,$page)
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
            ->setFirstResult($page * 12 -12)
            ->where('s.status = 2');
        if($user)
        {
            $rq->andWhere('s.user = :userId');
            $rq->setParameter('userId', $user);
        }
        if($category)
        {
            $rq->andWhere('s.category = :categoryId');
            $rq->setParameter('categoryId', $category);
        }

            return $rq->getQuery()->getResult();
    }

    // Recup du nombre total de spots validés par user
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


    // Recup de tous les spots refusés par User
    // Pour user dans mon compte
    public function findRejectedSpotsByUser($userId)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.date', 'DESC')
            ->where('u.user = :userId')
            ->andWhere('u.status = 0')
            ->setParameter('userId', $userId)
            ->setMaxResults(10);
        return $qb->getQuery()->getResult();
    }


    // Recup du nombre total de spots rejetés par user
    public function countSpotsRejectedByUser($userId)
    {
        $nb = $this
            ->createQueryBuilder('s')
            ->select('count(s) as nb')
            ->where('s.status = 0')
            ->andWhere('s.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult();
        return $nb;
    }


    // Recup du nombre total de spot par user
    // A VIRER JE PENSE !!!
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





}

