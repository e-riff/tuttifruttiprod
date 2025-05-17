<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/user', name: 'user_')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{

    public function __construct(
        #[Autowire('%mailer_from%')]
        private readonly string $mailerFrom,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
    )
    {
    }

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
        Request                      $request,
        EntityManagerInterface       $entityManager,
        MailerInterface              $mailer,
        UserPasswordHasherInterface      $passwordHasher
    ): Response
    {
        $userForm = $this->createForm(UserType::class);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user = $userForm->getData();
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($passwordHasher->hashPassword($user, bin2hex(random_bytes(10))));
            $entityManager->persist($user);
            $entityManager->flush();

            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
            $link = $this->generateUrl(
                'app_reset_password',
                ['token' => $resetToken->getToken()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $emailMessage = (new Email())
                ->from($this->mailerFrom)
                ->to($user->getEmail())
                ->subject('Création de votre compte administrateur')
                ->html(
                    "<p>Bienvenue ! Cliquez sur ce lien pour définir votre mot de passe : <a href=\"$link\">Définir mon mot de passe</a></p>",
                );

            $mailer->send($emailMessage);
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }

    #[Route('/{user}/resend-invite', name: 'resend_invite', methods: ['POST', 'GET'])]
    public function resendInvite(
        User $user,
        MailerInterface $mailer,
    ): Response {
        // On peut vérifier ici s'il a déjà un mot de passe ou un flag "invitation déjà envoyée"
        $resetToken = $this->resetPasswordHelper->generateResetToken($user);

        $link = $this->generateUrl(
            'app_reset_password',
            ['token' => $resetToken->getToken()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $emailMessage = (new Email())
            ->from($this->mailerFrom)
            ->to($user->getEmail())
            ->subject('Votre invitation administrateur')
            ->html(
                "<p>Bienvenue ! Cliquez sur ce lien pour définir votre mot de passe : <a href=\"$link\">Définir mon mot de passe</a></p>",
            );

        $mailer->send($emailMessage);

        $this->addFlash('success', 'Invitation renvoyée avec succès !');

        return $this->redirectToRoute('admin_user_index');
    }
}
