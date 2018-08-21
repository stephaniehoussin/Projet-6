<?php

namespace App\Services;

use App\Entity\Spot;
use App\Entity\User;
use App\Entity\Reject;
use Doctrine\ORM\EntityManagerInterface;


class SpotManager

{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function initSpot()
    {
        $spot = new Spot();
        return $spot;
    }

    public function save(Spot $spot, User $user)
    {
        if ($user->hasRole('ROLE_MODERATEUR'))
        {
            $spot->setStatus(Spot::STATUS_VALID);
        }
        $spot->setUser($user);
        $this->em->persist($spot);
        $this->em->flush();
    }

    public function persistSpot($spot)
    {
        $this->em->persist($spot);
        $this->em->flush();
    }

    public function suppressSpot($spot)
    {
        $this->em->remove($spot);
        $this->em->flush();
    }

}