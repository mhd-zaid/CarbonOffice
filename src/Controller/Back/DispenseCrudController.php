<?php

namespace App\Controller\Back;

use App\Entity\Dispense;
use App\Entity\Mentor;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Query\ResultSetMapping;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use LDAP\Result;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DispenseCrudController extends AbstractCrudController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    public static function getEntityFqcn(): string
    {
        return Dispense::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Formations planifiées')
            ->setPageTitle('new', 'Planifier une formation')
            ->setSearchFields(['title', 'description', 'skills.title'])
            ->overrideTemplate('crud/new', 'back/dispense/new.html.twig')
            ->overrideTemplate('crud/index', 'back/dispense/index.html.twig')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
      $users = $this->em->getRepository(User::class)->findAll();
      $consultants = [];
        foreach ($users as $user) {
            foreach ($user->getRoles() as $role) {
                if ($role === 'ROLE_CONSULTANT') {
                    $consultants[] = $user;
                }
            }
        }
        return [
            DateField::new('date'),
            TimeField::new('startTime'),
            AssociationField::new('mentor')->setFormTypeOptions([
                'class' => Mentor::class,
                'label' => 'Formation',
                'choice_label' => function ($mentor) {
                    return $mentor->getFormation()->getTitle();
                },
            ]),
            CollectionField::new('consultants')
                ->setFormTypeOptions([
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => User::class,
                        'choices' => $consultants,
                        'choice_label' => function ($user) {
                            return $user->getLastname() . ' - ' . $user->getFirstname();
                        },
                    ],
                ]),
        ];
    }
    
}
