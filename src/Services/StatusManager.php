<?php

namespace App\Services;

use App\Entity\Spot;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class StatusManager

{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function save(Spot $spot, User $user,$status)
    {
        if ($status == 2)
        {
            $spot->setStatus(Spot::STATUS_VALID);
        }elseif ($status == 0)
        {
            $spot->setStatus(Spot::STATUS_REJECT);
        }
        $spot->setUser($user);
        $this->em->persist($spot);
        $this->em->flush();
    }



}