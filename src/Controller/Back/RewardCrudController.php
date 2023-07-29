<?php

namespace App\Controller\Back;

use App\Entity\Dispense;
use App\Entity\Reward;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RewardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reward::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Attribuer une récompense')
            ->overrideTemplate('crud/new', 'back/reward/new.html.twig')
        ;
    }
    
    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         TextField::new('title'),
    //         TextEditorField::new('description'),
    //         AssociationField::new('dispense')->setFormTypeOptions([
    //             'class' => Dispense::class,
    //             'label' => 'Formation Planifiée',
    //             'choice_label' => 'formation.title'
    //         ]),
    //         CollectionField::new('users')
    //         ->setFormType(CollectionType::class)
    //         ->setFormTypeOptions([
    //             'entry_type' => EntityType::class,
    //             'entry_options' => [
    //                 'class' => User::class,
    //                 'choice_label' => 'fullname',
    //             ],
    //         ])
    //         ->onlyOnForms(),
            
    //     ];
    // }
}
