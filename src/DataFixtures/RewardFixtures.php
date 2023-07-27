<?php

namespace App\DataFixtures;

use App\Entity\Reward;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RewardFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $technos = ['PHP', 'Java', 'Python', 'C#', 'Ruby'];
        foreach ($technos as $techno){
            $object = (new Reward())
                ->setTitle('Certificat de développeur ' . $techno)
                ->setDescription('Ce certificat atteste que le titulaire a terminé une formation de développeur ' . $techno . '.')
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
