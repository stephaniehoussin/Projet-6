<?php

namespace tests\Entity;

use App\Entity\Spot;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SpotTest extends WebTestCase
{

    public function testSpot()
    {
        $spot = new Spot();
        $spot->setLatitude('48.86');
        $spot->setLongitude('2.28');
        $spot->setTitle('Endroit superbe');
        $spot->setDescription('Vraiment magique et préservé');
        $user = new User();
        $user->setUsername('Valentin');
        $this->assertEquals('48.86', $spot->getLatitude());
        $this->assertEquals('2.28', $spot->getLongitude());
        $this->assertEquals('Endroit superbe', $spot->getTitle());
        $this->assertEquals('Vraiment magique et préservé', $spot->getDescription());
        $this->assertEquals('Valentin', $user->getUsername());
    }
}