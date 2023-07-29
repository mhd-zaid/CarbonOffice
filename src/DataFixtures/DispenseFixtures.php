<?php

namespace App\DataFixtures;

use App\Entity\Dispense;
use App\Entity\Formation;
use App\Entity\Mentor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DispenseFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $mentors = $manager->getRepository(Mentor::class)->findBy(['status' => true]);
        $users = $manager->getRepository(User::class)->findAll();
        $formations = $manager->getRepository(Formation::class)->findAll();
        $consultants = [];
        foreach ($users as $user) {
            if ($user->getRoles()[0] == 'ROLE_CONSULTANT') {
                array_push($consultants, $user);
            }
        }

        for ($i = 0; $i < 50; $i++){
            $nbConsultants = random_int(1, 3);
            $mentor = $mentors[random_int(0, count($mentors) - 1)];
            $object =(new Dispense())
                ->setDate($faker->dateTimeBetween('-2 months', '+2 months'))
                ->setStartTime($faker->dateTimeBetween('-1 months'))
                ->setLink($faker->url)
                ->setMentor($mentor)
                ->setFormation($mentor->getFormation())
            ;
            for( $j = 0; $j < $nbConsultants; $j++) {
                $object->addConsultant($consultants[random_int(0, count($consultants) - 1)]);
            }
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getorder(): int
    {
        return 8;
    }
}
