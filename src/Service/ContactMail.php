<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactMail extends AbstractController
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepository  $userRepository
    )
    {
    }

    public function sendMail(array $dataMessage = []): void
    {
        $admins = $this->userRepository->findBy([], [], 5);

        foreach ($admins as $admin) {
            $email = (new Email())
                ->to($admin->getEmail())
//                ->from($this->getParameter('mailer_from'))
                ->from($dataMessage['email'])
                ->subject("Nouveau message pour Tutti Frutti Pro")
                ->html($this->renderView('_include/_MailContact.html.twig', [
                    'admin' => $admin,
                    'dataMessage' => $dataMessage,
                ]));
            $this->mailer->send($email);
        }
    }
}