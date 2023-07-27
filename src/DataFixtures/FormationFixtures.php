<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use App\Entity\Reward;
use App\Entity\Skills;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Form;

class FormationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rewards = $manager->getRepository(Reward::class);
        $skills = $manager->getRepository(Skills::class)->findAll();

        $object = (new Formation())
            ->setTitle('Démarrer avec Symfony 6')
            ->setDescription('Cette formation est le meilleur point de départ pour vous préparer aux outils et aux usages avancés du framework Symfony 6 avec ses créateurs. SensioLabs University a conçu la meilleure...')
            ->setRequirements('Bonne connaissance du langage PHP et de la programmation orientée objet.')
            ->setDuration(120)
            ->setReward($rewards->find(1))
            ->addSkill($skills[0])
        ;
        $manager->persist($object);

        $object = (new Formation())
            ->setTitle('Agile/Scrum')
            ->setDescription('La méthodologie Agile est une alternative à la gestion des projets cycle en V, elle repose sur plusieurs principes : un pilotage orienté qualité Produit, la coopération d’un Product Owner avec l’Equipe de Réalisation et le Scrum Master pour maximiser la valeur du Produit, la priorisation du développement par la valeur métier et le risque et la possibilité de faire évoluer le périmètre.')
            ->setRequirements('Notions de gestion de projet')
            ->setDuration(90)
            ->setReward($rewards->find(1))
            ->addSkill($skills[0])
            ->addSkill($skills[1])
            ->addSkill($skills[2])
        ;
        $manager->persist($object);

        $object = (new Formation())
            ->setTitle('Écrire ses premiers tests unitaires avec PHPUnit !')
            ->setDescription('Ce cours d’une demi-journée permet aux apprenants de savoir quoi, quand et comment tester du code PHP.')
            ->setRequirements('Compétences : Bonne maîtrise de PHP, et de son IDE (de préférences PHPStorm). Techniques : PHP à jour (7.2.5 minimum), Composer.')
            ->setDuration(60)
            ->setReward($rewards->find(1))
            ->addSkill($skills[0])
        ;
        $manager->persist($object);

        $object = (new Formation())
            ->setTitle('Tests avancés et fonctionnels avec Symfony')
            ->setDescription('Ce cours d’une demi-journée montre les différents rouages des tests fonctionnels.')
            ->setRequirements('Compétences : Bonne maîtrise de PHP, de son IDE (de préférences PHPStorm) et de Symfony. Outils obligatoires : PHP 7.2.5 ou +, Composer, Symfony CLI.')
            ->setDuration(320)
            ->setReward($rewards->find(1))
            ->addSkill($skills[0])
        ;
        $manager->persist($object);

        $object = (new Formation())
            ->setTitle('Composant Messenger - Débutant')
            ->setDescription('Dans ce module consacré au composant Messenger, apprenez à rendre vos applications plus efficaces en déléguant les traitements coûteux en ressources et en améliorant l\'expérience utilisateur, apprenez aussi à gérer les erreurs et les montées en charge afin de gérer les tâches urgentes..')
            ->setRequirements('Maitrise du language PHP, Expérience avec Symfony')
            ->setDuration(150)
            ->setReward($rewards->find(1))
            ->addSkill($skills[0])
            ->addSkill($skills[2])

        ;
        $manager->persist($object);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }

}
