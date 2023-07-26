<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\UserRepository;
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

    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
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
    ]   );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Carbon Office')
            ->renderContentMaximized()
            ->generateRelativeUrls()
            ;
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
                MenuItem::linkToRoute('Formations', 'fa fa-lines-leaning', ''),
                MenuItem::linkToRoute('Mentoring', 'fa fa-chalkboard', ''),

            MenuItem::section('Espace communauté'),
                MenuItem::linkToRoute('Actualité', 'fa fa-people-group', ''),

            MenuItem::section('Espace planification'),
                MenuItem::linkToRoute('Planning', 'fa fa-calendar-days', ''),

            MenuItem::section('Espace personnel'),
                MenuItem::linkToRoute('Mon compte', 'fa fa-user', 'back_default_index'),
                MenuItem::linkToRoute('Paramètre', 'fa fa-sliders', ''),

            MenuItem::linkToLogout("Déconnexion", 'fa fa-sign-out-alt'),

        ];

    }

    public function configureUserMenu(User|UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getFullName())
            ->setGravatarEmail($user->getEmail())
//
//            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('Mon compte', 'fa fa-user', 'back_default_index'),
                MenuItem::linkToRoute('Paramètre', 'fa fa-sliders', ''),
            ])
        ;
    }
}
