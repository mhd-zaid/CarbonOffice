<?php

namespace App\Controller\Back;

use App\Entity\Formation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Formations')
            ->setPageTitle('edit', 'Editer une formation')
            ->setPageTitle('new', 'Créer une formation')
            ->overrideTemplate('crud/index', 'back/formation/index.html.twig')
            ->overrideTemplate('crud/edit', 'back/formation/edit.html.twig')
            ->overrideTemplate('crud/new', 'back/formation/new.html.twig');
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
