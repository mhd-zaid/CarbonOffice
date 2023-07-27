<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile_index', methods: ['GET'])]
    public function index(Security $security): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        return $this->render('back/userConnected/index.html.twig', [
            'user' => $user,
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_account_edit', methods: ['GET', 'POST'])]
    // #[Security('user === user')]
    // public function edit(Request $request, EntityManagerInterface $em): Response
    // {
    //     $user = $this->getUser(); // Récupérer l'utilisateur connecté via le service Security

    //     $form = $this->createForm(AccountType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->getRepository(User::class)->save($user, true);
    //         $this->addFlash(
    //             'success',
    //             'L\'utilisateur a bien été modifié'
    //         );
    //         return $this->redirect('http://localhost:8000/admin?routeName=back_profile_index');
    //     } elseif ($form->isSubmitted() && !$form->isValid()) {
    //         $this->addFlash(
    //             'error',
    //             'Une erreur est survenue lors de la modification de l\'utilisateur'
    //         );
    //     }
    //     return $this->renderForm('back/userConnected/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //         'entity' => 'user'
    //     ]);
    // }
}
