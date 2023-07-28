<?php

namespace App\Controller\Back;

use App\Entity\Dispense;
use App\Entity\Formation;
use App\Entity\Mentor;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use phpDocumentor\Reflection\DocBlock\Tags\Link;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
            ->setFormOptions(['validation_groups' => false])
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
            AssociationField::new('formation')->setFormTypeOptions([
                'class' => Formation::class,
                'label' => 'Formation',
                'choice_label' => 'title'
            ]),
            IntegerField::new('mentor')->setFormTypeOptions([
                'mapped' => false,
                'data' => null,
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
            UrlField::new('link'),
        ];
    }
    
    public function new(AdminContext $context)
    {
        $event = new BeforeCrudActionEvent($context);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
        $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
        $context->getCrud()->setFieldAssets($this->getFieldAssets($context->getEntity()->getFields()));
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $newForm->handleRequest($context->getRequest());

        $entityInstance = $newForm->getData();
        $context->getEntity()->setInstance($entityInstance);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->processUploadedFiles($newForm);
            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();
            $entityInstance->setMentor($this->em->getRepository(Mentor::class)->find(intval($_POST['Dispense']['mentor'])));
            $this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

            $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
            $context->getEntity()->setInstance($entityInstance);

            return $this->getRedirectResponseAfterSave($context, Action::NEW);
        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $newForm,
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        return $responseParameters;
    }

    public function delete(AdminContext $context): RedirectResponse
    {
        $dispense = $context->getEntity()->getInstance();
        $this->em->remove($dispense);
        $this->em->flush();
        $this->addFlash('success', 'La formation planifiée a bien été supprimée');
        return $this->redirect($this->container->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }
}
