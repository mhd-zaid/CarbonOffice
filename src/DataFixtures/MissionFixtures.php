<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MissionFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();

        for($i = 0; $i < 10; $i++){
            $object = (new Mission())
                ->setManager($users[random_int(0, count($users) - 1)])
                ->setCompany($faker->company)
                ->setStartDate($faker->dateTimeBetween('-2 years', 'now'))
                ->setEndDate($faker->dateTimeBetween('now', '+2 years'))
                ->setDescription($faker->text(200))
                ->setStatus($faker->randomElement(['En cours', 'Terminée']))
                ->addConsultant($users[random_int(0, count($users) - 2)])
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
