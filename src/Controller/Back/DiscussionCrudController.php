<?php

namespace App\Controller\Back;

use App\Entity\Discussion;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class DiscussionCrudController extends AbstractCrudController
{
    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Discussion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Discussion')
            ->setPageTitle('new', 'Créer un post')
            ->overrideTemplate('crud/index', 'back/actualite/index.html.twig')
            ->overrideTemplate('crud/new', 'back/actualite/new.html.twig');
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
