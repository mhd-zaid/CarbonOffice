<?php

namespace App\Controller\Back;

use App\Entity\Planning;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Faker\Provider\ar_EG\Text;
use Symfony\Component\Routing\Annotation\Route;

class PlanningCrudController extends AbstractCrudController
{
    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public static function getEntityFqcn(): string
    {
        return Planning::class;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $showAction = Action::new('Show', '')
            ->setIcon('fas fa-show')
            ->linkToCrudAction('renderShow');

        return $actions
            ->add(Crud::PAGE_INDEX, $showAction);

    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('dateStart')->onlyOnForms()->setFormTypeOptions([
                'html5' => true,
                'widget' => 'single_text',
            ]),
            DateField::new('dateEnd')->onlyOnForms()->setFormTypeOptions([
                'html5' => true,
                'widget' => 'single_text',
            ]),
            ChoiceField::new('type')->onlyOnForms()->setChoices([
                'Choisir une option' => null,
                'Jour de travail' => 'Work',
                'Jour de congé' => 'Leave',
            ]),
            TextField::new('consultant.lastname')->onlyOnIndex()->setLabel('Nom du consultant'),
            TextField::new('consultant.firstname')->onlyOnIndex()->setLabel('Prénom du consultant'),
        ];
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud->setPageTitle('index', 'Planning')
    //         ->setPageTitle('edit', 'Editer un évènement')
    //         ->setPageTitle('new', 'Créer un évènement')
    //        // ->overrideTemplate('crud/index', 'back/planning/index.html.twig');
    //         //->overrideTemplate('crud/edit', 'back/planning/edit.html.twig');
            
    //         //setTemplatePath('bundles/EasyAdminBundle/crud/index.html.twig');
    // }

    public function index(AdminContext $context)
    {
        $users = $this->em->getRepository(User::class)->findAll();

        return $this->render('back/planning/index.html.twig', [
            'users' => $users,
        ]);
    }

    public function show(AdminContext $context)
    {   
        $userId = $context->getRequest()->query->get('userId');
        $plannings = $this->em->getRepository(Planning::class)->findBy(['consultant' => $userId]);

        return $this->render('back/planning/show.html.twig', [
            'plannings' => $plannings,
        ]);
    }
}
