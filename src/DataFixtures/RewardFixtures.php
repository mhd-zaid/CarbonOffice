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
        $users = $manager->getRepository(User::class)->findAll();
        $consultants = [];
        foreach ($users as $user) {
            if ($user->getRoles()[0] == 'ROLE_CONSULTANT') {
                array_push($consultants, $user);
            }
        }
        $dispenses = $manager->getRepository(Dispense::class)->findAll();
        $tabLevel = [10, 19, 22, 3, 223, 57];
        for($i = 0; $i < 3; $i++) {
            $object = (new Reward())
                ->setConsultant($consultants[$i])
                ->setLevel($tabLevel[random_int(0, count($tabLevel) - 1)])
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}
