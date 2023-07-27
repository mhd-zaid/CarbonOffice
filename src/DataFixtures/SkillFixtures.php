<?php

namespace App\DataFixtures;

use App\Entity\Skills;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $object = (new Skills())
            ->setTitle('PHP')
            ->setDescription('PHP est un langage de programmation libre, principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP.')
        ;
        $manager->persist($object);

        $object = (new Skills())
            ->setTitle('Java')
            ->setDescription('Java est un langage de programmation orienté objet créé par James Gosling et Patrick Naughton, employés de Sun Microsystems, avec le soutien de Bill Joy (cofondateur de Sun Microsystems en 1982), présenté officiellement le 23 mai 1995 au SunWorld.')
        ;
        $manager->persist($object);

        $object = (new Skills())
            ->setTitle('Python')
            ->setDescription('Python est un langage de programmation interprété, multi-paradigme et multiplateformes. Il favorise la programmation impérative structurée, fonctionnelle et orientée objet.')
        ;
        $manager->persist($object);

        $object = (new Skills())
            ->setTitle('C#')
            ->setDescription('C# est un langage de programmation orienté objet, commercialisé par Microsoft depuis 2002 et destiné à développer sur la plateforme Microsoft .NET.')
        ;
        $manager->persist($object);

        $object = (new Skills())
            ->setTitle('Ruby')
            ->setDescription('Ruby est un langage de programmation libre, interprété, réflexif et orienté objet créé par Yukihiro « Matz » Matsumoto, qui a voulu concilier une syntaxe inspirée de Python et de Perl avec une approche objet à la Smalltalk.')
        ;
        $manager->persist($object);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
