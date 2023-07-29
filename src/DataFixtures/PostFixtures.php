<?php

namespace App\DataFixtures;

use App\Entity\Discussion;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();
        $discussions = $manager->getRepository(Discussion::class)->findAll();

        for ($i = 0; $i < 13; $i++){
            $object =(new Post())
                ->setDate($faker->dateTimeBetween('-6 months'))
                ->setMessage($faker->text(200))
                ->setEmployee($users[random_int(0, count($users) - 1)])
                ->setDiscussion($discussions[random_int(0, count($discussions) - 1)])
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getorder(): int
    {
        return 7;
    }
}
