<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $pwd = '$2y$13$cxyypcYcyj4sQhaeLhojvucbBwbWo789iF/Aqqsvm2Rpcu/jNxIf6';

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;
        $manager->persist($object);


        $manager->flush();
    }
}
