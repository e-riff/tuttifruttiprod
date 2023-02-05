<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

class ContactMail
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UserRepository $userRepository,
        private readonly ParameterBagInterface $parameterBag
    ) {
    }

    public function sendMail(array $dataMessage = []): void
    {
        $admins = $this->userRepository->findBy([], [], 5);

        foreach ($admins as $admin) {
            $email = (new TemplatedEmail())
                ->to($admin->getEmail())
                ->from($this->parameterBag->get('mailer_from'))
                ->from($dataMessage['email'])
                ->subject("Nouveau message pour Tutti Frutti Pro")
                ->htmlTemplate('_include/_MailContact.html.twig')
                ->context([
                    'admin' => $admin,
                    'dataMessage' => $dataMessage,
                ]);
            $this->mailer->send($email);
        }
    }
}
