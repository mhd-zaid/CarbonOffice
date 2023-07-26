<?php

namespace App\Controller\Back;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Details'),
            TextField::new('lastname')
                ->setLabel('Nom')
                ->setCustomOption('attr', ['class' => 'lastname']), // Ajoutez une classe CSS personnalisée au champ "lastname",
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('email')->onlyOnForms(),
            TextField::new('plainPassword')->onlyOnForms(),
            TextField::new('email'),
            FormField::addTab('Address')->onlyOnForms(),
            TextField::new('phone')->onlyOnForms(),
            TextField::new('address')->onlyOnForms(),
            TextField::new('city')->onlyOnForms(),
            NumberField::new('zipCode')->onlyOnForms(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Utilisateurs')
            ->setPageTitle('edit', 'Editer un utilisateur')
            ->setPageTitle('new', 'Créer un utilisateur')
            ->overrideTemplate('crud/index', 'back/user/index.html.twig')
            ->overrideTemplate('crud/edit', 'back/user/edit.html.twig')
            ->overrideTemplate('crud/new', 'back/user/new.html.twig');
    }
}
