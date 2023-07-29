<?php

namespace App\DataFixtures;

use App\Entity\Dispense;
use App\Entity\Reward;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RewardFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $consultants = $manager->getRepository(User::class)->findAll();
        $dispenses = $manager->getRepository(Dispense::class)->findAll();
        for($i = 0; $i < 10; $i++) {
            $object = (new Reward())
                ->setConsultant($consultants[random_int(0, count($consultants) - 1)])
                ->setDispense($dispenses[random_int(0, count($dispenses) - 1)])
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
