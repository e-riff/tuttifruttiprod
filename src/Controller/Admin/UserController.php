<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class UserController extends AbstractController
{
    #[Route('/invite', name: 'invite_user', methods: ['POST'])]
    public function inviteAdmin(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer,
        ResetPasswordHelperInterface $resetPasswordHelper
    ): Response {
        $email = $request->request->get('email');

        if (!$email) {
            return new Response('Email is required', 400);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']); // ou ['ROLE_SUPER_ADMIN'] selon le besoin
        $entityManager->persist($user);
        $entityManager->flush();

        // Générer un lien de réinitialisation (ou de création)
        $resetToken = $resetPasswordHelper->generateResetToken($user);

        // Envoyer l'email avec le lien
        $emailMessage = (new Email())
            ->from('noreply@tondomaine.com')
            ->to($email)
            ->subject('Création de votre compte administrateur')
            ->html(sprintf(
                '<p>Bienvenue ! Cliquez sur ce lien pour définir votre mot de passe : <a href="%s">%s</a></p>',
                $this->generateUrl('app_reset_password', ['token' => $resetToken->getToken()]),
                'Définir mon mot de passe'
            ));

        $mailer->send($emailMessage);

        return new Response('Invitation envoyée avec succès');
    }
}
