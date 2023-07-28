<?php

namespace App\DataFixtures;

use App\Entity\Discussion;
use App\Entity\Formation;
use App\Entity\Reward;
use App\Entity\Skills;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Form;

class DiscussionFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rewards = $manager->getRepository(Reward::class);
        $skills = $manager->getRepository(Skills::class)->findAll();

        foreach ($skills as $skill) {
            $object = (new Discussion())
            ->setTitle('Discussion sur '.$skill->getTitle())
            ->setDescription('Discussion sur '.$skill->getTitle())
            ->setSkill($skill)
        ;
        $manager->persist($object);

        $manager->flush();
        }
    }

    public function getOrder()
    {
        return 6;
    }

}
