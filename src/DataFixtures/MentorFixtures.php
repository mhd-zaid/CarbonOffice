<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use App\Entity\Mentor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MentorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $formations = $manager->getRepository(Formation::class)->findAll();
        for($i = 0; $i < 7; $i++)
        {
            $object = (new Mentor())
                ->setConsultant($users[random_int(0, count($users) - 1)])
                ->setFormation($formations[random_int(0, count($formations) - 1)])
                ->setStatus(random_int(0, 1))
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
