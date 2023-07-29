<?php

namespace App\DataFixtures;

use App\Entity\Skills;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $pwd = '$2y$13$cxyypcYcyj4sQhaeLhojvucbBwbWo789iF/Aqqsvm2Rpcu/jNxIf6';
        $skills = $manager->getRepository(Skills::class)->findAll();

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setAge($faker->randomDigit())
            ->setPhone($faker->phoneNumber)
            ->setAddress($faker->address)
            ->setCity($faker->city)
            ->setZipCode(str_replace(" ", "", $faker->postcode))
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
            ->addSkill($skills[0])
            ->addSkill($skills[1])
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('rh@user.fr')
            ->setRoles(['ROLE_RH'])
            ->setPassword($pwd)
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setAge($faker->randomDigit())
            ->setPhone($faker->phoneNumber)
            ->setAddress($faker->address)
            ->setCity($faker->city)
            ->setZipCode(str_replace(" ", "", $faker->postcode))
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
            ->addSkill($skills[1])
            ->addSkill($skills[2])
        ;
        $manager->persist($object);

        for ($i = 0; $i<3; $i++) {
            $object = (new User())
                ->setRoles(['ROLE_CONSULTANT'])
                ->setPassword($pwd)
                ->setFirstname($faker->firstName)
                ->setEmail('consultant.'.$i.'@user.fr')
                ->setLastname($faker->lastName)
                ->setAge($faker->randomDigit())
                ->setPhone($faker->phoneNumber)
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setZipCode(str_replace(" ", "", $faker->postcode))
                ->setCreatedAt(new DateTime())
                ->setUpdatedAt(new DateTime())
            ;
            $nbskills = random_int(1, 4);
            for ($j = 0; $j < $nbskills; $j++) {
                $object->addSkill($skills[random_int(0, count($skills) - 1)]);
            }
            $manager->persist($object);
        }


        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
