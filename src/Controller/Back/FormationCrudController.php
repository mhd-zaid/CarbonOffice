<?php

namespace App\Controller\Back;

use App\Entity\Formation;
use App\Entity\Skills;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FormationCrudController extends AbstractCrudController
{

    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Formations')
            ->setPageTitle('edit', 'Editer une formation')
            ->setPageTitle('new', 'Créer une formation')
            ->setSearchFields(['title', 'description', 'skills.title'])
            ->overrideTemplate('crud/index', 'back/formation/index.html.twig')
            ->overrideTemplate('crud/edit', 'back/formation/edit.html.twig')
            ->overrideTemplate('crud/new', 'back/formation/new.html.twig')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $skillsRepository = $this->em->getRepository(Skills::class);
        $skills = $skillsRepository->findAll();
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            NumberField::new('duration'),
            TextEditorField::new('requirements'),
//            ChoiceField::new('skills')->setChoices($skills),
            CollectionField::new('skills')
                ->setFormType(CollectionType::class)
                ->setFormTypeOptions([
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Skills::class,
                    ],
                ])
                ->onlyOnForms(),
        ];
    }


    public function delete(AdminContext $context): RedirectResponse
    {
        $formation = $context->getEntity()->getInstance();
        $this->em->remove($formation);
        $this->em->flush();
        $this->addFlash('success', 'La formation a bien été supprimée');
        return $this->redirect($this->container->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }
}
