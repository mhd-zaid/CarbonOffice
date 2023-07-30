<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Entity\Skills;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserCrudController extends AbstractCrudController
{

    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Utilisateurs')
            ->setPageTitle('edit', 'Editer un utilisateur')
            ->setPageTitle('new', 'Créer un utilisateur')
            ->setSearchFields(['lastname', 'firstname', 'email', 'phone', 'address', 'city', 'zipCode', 'skills.title'])
            ->overrideTemplate('crud/edit', 'back/user/edit.html.twig')
            ->overrideTemplate('crud/index', 'back/user/index.html.twig')
            ->overrideTemplate('crud/new', 'back/user/new.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        $skillsRepository = $this->em->getRepository(Skills::class);
        $skills = $skillsRepository->findAll();

        $skillChoices = [];
        foreach ($skills as $skill) {
            $skillChoices[$skill->getTitle()] = $skill;
        }
        return [
            FormField::addTab('Details'),
            TextField::new('lastname')->setLabel('Nom'),
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('email')->onlyOnForms(),
            TextField::new('plainPassword')->onlyOnForms(),
            IntegerField::new('age')->onlyOnForms(),
            FormField::addTab('Address')->onlyOnForms(),
            TextField::new('phone')->onlyOnForms()->setLabel('Téléphone'),
            TextField::new('address')->onlyOnForms()->setLabel('Adresse'),
            TextField::new('city')->onlyOnForms()->setLabel('Ville'),
            NumberField::new('zipCode')->onlyOnForms()->setLabel('Code postale'),
            CollectionField::new('skills')
                ->setFormType(CollectionType::class) // Remplacez collectionType::class par CollectionType::class
                ->setFormTypeOptions([
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Skills::class, // Remplacez VotreClasseCible par la classe de votre entité cible
                    ],
                ])
        ];
    }

    public function delete(AdminContext $context): RedirectResponse
    {
        $formation = $context->getEntity()->getInstance();
        $this->em->remove($formation);
        $this->em->flush();
        $this->addFlash('success', 'Le consultant a bien été supprimé');
        return $this->redirect($this->container->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }
}
