<?php

namespace App\Controller\Back;

use App\Entity\Discussion;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\Choices;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCrudController extends AbstractCrudController
{

    public function __construct(private EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Post')
            ->setPageTitle('new', 'Créer un post');
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_NEW === $pageName) {
            // Obtenez la liste des discussions depuis votre base de données
            $discussions = $this->em->getRepository(Discussion::class)->findAll();

            // Convertissez les objets Discussion en un tableau pour les utiliser dans le champ ChoiceField
            $discussionChoices = [];
            foreach ($discussions as $discussion) {
                $discussionChoices[$discussion->getSkill()->getTitle()] = $discussion;
            }

            return [
                TextareaField::new('message'),
                ChoiceField::new('discussion')
                    ->setLabel('Discussion')
                    ->setChoices($discussionChoices)
                    ->setRequired(true)
                    ->autocomplete() // Cette option ajoute une fonctionnalité de saisie semi-automatique au champ
            ];
        } else {
            // Configurations pour les autres pages si nécessaire
            return [];
        }
    }

    public function new(AdminContext $context)
    {
        $post = new Post();

        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $newForm->handleRequest($context->getRequest());

        // Check if the form is submitted and valid
        if ($newForm->isSubmitted() && $newForm->isValid()) {
            // Get the currently logged-in user
            $user = $this->getUser();
            $post->setEmployee($user);


            $message = $newForm->get('message')->getData();
            $post->setMessage($message);

            $discussionId = $newForm->get('discussionId')->getData();
            $discussion = $this->em->getRepository(Discussion::class)->find($discussionId);
            $post->setDiscussion($discussion);

            // Set the date of the post to today's date
            $post->setDate(new \DateTime());

            // Persist the post to the database
            $this->em->persist($post);
            $this->em->flush();

            return $this->redirect($this->container->get(AdminUrlGenerator::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());

        }

        $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
            'pageName' => Crud::PAGE_NEW,
            'templateName' => 'crud/new',
            'entity' => $context->getEntity(),
            'new_form' => $newForm,
        ]));

        return $responseParameters;
    }

    public function sendPost(AdminContext $context): RedirectResponse
    {
        $post = new Post();
        $post->setEmployee($this->getUser());
        $post->setDate(new \DateTime());
        $post->setMessage($context->getRequest()->get('post'));
        $post->setDiscussion($this->em->getRepository(Discussion::class)->find($context->getRequest()->get('discussionId')));
        $this->em->persist($post);
        $this->em->flush();

        return $this->redirect($this->container->get(AdminUrlGenerator::class)->setController(DiscussionCrudController::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl());
    }

}
