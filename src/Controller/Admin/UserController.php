<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/user', name: 'user_')]
#[IsGranted('ROLE_SUPER_ADMIN')]
class UserController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function inviteAdmin(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        ResetPasswordHelperInterface $resetPasswordHelper
    ): Response {
        $userForm = $this->createForm(UserType::class);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user = $userForm->getData();
            $entityManager->persist($user);
            $entityManager->flush();

            // Générer un lien de réinitialisation (ou de création)
            $resetToken = $resetPasswordHelper->generateResetToken($user);

            // Envoyer l'email avec le lien
            $emailMessage = (new Email())
                ->from('noreply@tondomaine.com')
                ->to($user->getEmail())
                ->subject('Création de votre compte administrateur')
                ->html(sprintf(
                    '<p>Bienvenue ! Cliquez sur ce lien pour définir votre mot de passe : <a href="%s">%s</a></p>',
                    $this->generateUrl('app_reset_password', ['token' => $resetToken->getToken()]),
                    'Définir mon mot de passe'
                ));

            $mailer->send($emailMessage);
            $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }
}
