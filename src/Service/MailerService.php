<?php

namespace App\Service;

use App\Entity\Band;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly class MailerService
{
    public function __construct(
        private MailerInterface       $mailer,
        private UserRepository        $userRepository,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    public function sendContactMail(array $dataMessage = []): void
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
                    'user' => $admin,
                    'dataMessage' => $dataMessage,
                ]);
            $this->mailer->send($email);
        }
    }

    public function sendContactMailForBand(Band $band, array $dataMessage = []): void
    {
        $bandLeader = $band->getLeader();
        $contacts = $bandLeader ? [$bandLeader] : $this->userRepository->findBy([], [], 5);
        foreach ($contacts as $contact) {
            $email = (new TemplatedEmail())
                ->to($contact->getEmail())
                ->from($this->parameterBag->get('mailer_from'))
                ->from($dataMessage['email'])
                ->subject("Contact pour {$band->getName()}")
                ->htmlTemplate('_include/_MailContact.html.twig')
                ->context([
                    'user' => $band->getLeader(),
                    'dataMessage' => $dataMessage,
                ]);
            $this->mailer->send($email);
        }

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
