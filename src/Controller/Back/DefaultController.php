<?php

namespace App\Controller\Back;

use App\Entity\Discussion;
use App\Entity\Dispense;
use App\Entity\Formation;
use App\Entity\Mentor;
use App\Entity\Planning;
use App\Entity\User;
use App\Repository\MentorRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractDashboardController
{
    private $userRepository;
    private $security;
    private $em;

    public function __construct(UserRepository $userRepository, Security $security, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->em = $em;
    }

    #[Route('/', name: 'default_index')]
    public function index(): Response
    {
        $dispenses = $this->em->getRepository(Dispense::class)->findAll();

        return $this->render('back/default/index.html.twig', [
            'dispenses' => $dispenses,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Carbon Office')
            ->renderContentMaximized()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Espace entreprise'),
            MenuItem::linkToUrl('Organigramme', 'fa fa-sitemap',  $this->container->get(AdminUrlGenerator::class)->setController(UserCrudController::class)->setAction(Action::INDEX)->unset(EA::ENTITY_ID)->generateUrl()),
            MenuItem::linkToUrl('Nouveau Collaborateurs', 'fa fa-users', $this->container->get(AdminUrlGenerator::class)->setController(UserCrudController::class)->setAction(Action::NEW)->unset(EA::ENTITY_ID)->generateUrl())->setPermission('ROLE_RH'),

            MenuItem::section('Espace formations'),
            MenuItem::linkToCrud('Formations', 'fa fa-lines-leaning', Formation::class),
            MenuItem::linkToCrud('Mentoring', 'fa fa-chalkboard', Mentor::class),

            MenuItem::section('Espace communauté'),
            MenuItem::linkToCrud('Discussions', 'fa fa-people-group', Discussion::class),

            MenuItem::section('Espace planification'),
            MenuItem::linkToCrud('Planning', 'fa fa-calendar-days', Planning::class),
            MenuItem::linkToCrud('Dispenses', 'fa fa-calendar-check', Dispense::class),

            MenuItem::section('Nos réseaux'),
            MenuItem::linkToUrl('LinkedIn', 'fa-brands fa-linkedin', 'https://www.linkedin.com/company/carbon-it/'),
            MenuItem::linkToUrl('Instagram', 'fa-brands fa-instagram', 'https://www.instagram.com/carbonitparis/?hl=fr'),
            MenuItem::linkToUrl('Twitter', 'fa-brands fa-twitter', 'https://twitter.com/carbonparis'),
            MenuItem::linkToUrl('Medium', 'fa-brands fa-medium', 'https://communitycarbonit.medium.com/'),

//            MenuItem::section('Espace personnel'),
//            MenuItem::linkToRoute('Mon compte', 'fa fa-user', 'back_profile_index'),

        ];
    }

    public function configureUserMenu(User|UserInterface $user): UserMenu
    {
        return UserMenu::new()
        ->displayUserName()
        ->displayUserAvatar()
        ->setName($user->getFullName())
        ->setGravatarEmail($user->getEmail())
        ->addMenuItems([
            MenuItem::linkToRoute('Mon compte', 'fa fa-user', 'back_profile_index'),
            MenuItem::linkToLogout("Déconnexion", 'fa fa-sign-out-alt'),
        ]);
    }

    #[Route('/mentor-formation/{formationId}', name: 'app_mentorByFormation')]
    public function getMentorByFormation(int $formationId): Response
    {
        $mentors = $this->em->getRepository(Mentor::class)->findBy(['formation' => $formationId]);
        $mentors = array_map(function ($mentor) {
            return [
                'id' => $mentor->getId(),
                'consultant' => $mentor->getConsultant()->getFullName(),
            ];
        }, $mentors);
        return $this->json($mentors);
    }
}
