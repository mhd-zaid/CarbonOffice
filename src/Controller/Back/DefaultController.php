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
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends AbstractDashboardController
{
    private $userRepository;
    private $security;
    private $em;

    public function __construct(UserRepository $userRepository, Security $security,EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->em = $em;
    }

    #[Route('/', name: 'default_index')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        $users = $this->userRepository->findAll();

        return $this->render('back/default/index.html.twig', [
            'users' => $users,
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
            MenuItem::linkToRoute('Organigramme', 'fa fa-sitemap', ''),
            MenuItem::linkToCrud('Nouveau Collaborateur', 'fa fa-user-plus', User::class)
                ->setPermission('ROLE_ADMIN'),

            MenuItem::section('Espace formations'),
            MenuItem::linkToCrud('Formations', 'fa fa-lines-leaning', Formation::class),
            MenuItem::linkToCrud('Mentoring', 'fa fa-chalkboard', Mentor::class),

            MenuItem::section('Espace communauté'),
            MenuItem::linkToCrud('Actualité', 'fa fa-people-group', Discussion::class),

            MenuItem::section('Espace planification'),
            MenuItem::linkToCrud('Planning', 'fa fa-calendar-days', Planning::class),
            MenuItem::linkToCrud('Dispenses', 'fa fa-calendar-check', Dispense::class),

            MenuItem::section('Espace personnel'),
            MenuItem::linkToRoute('Mon compte', 'fa fa-user', 'back_profile_index'),

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
            MenuItem::linkToRoute('Paramètre', 'fa fa-sliders', ''),
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
