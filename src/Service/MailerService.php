<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Band;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private UserRepository $userRepository,
        private ParameterBagInterface $parameterBag,
        #[Autowire('%mailer_from%')]
        private string $mailerFrom,
    ) {
    }

    public function sendContactMail(array $dataMessage = []): void
    {
        $admin = $this->userRepository->findBy([], [], 5);
        $email = (new TemplatedEmail())
            ->to(...array_map(fn ($admin) => $admin->getEmail(), $admin))
            ->from($this->mailerFrom)
            ->subject('Nouveau message pour Tutti Frutti Pro')
            ->htmlTemplate('_include/_MailContact.html.twig')
            ->context([
                'user' => $admin,
                'dataMessage' => $dataMessage,
            ]);
        $this->mailer->send($email);
    }

    public function sendContactMailForBand(Band $band, array $dataMessage = []): void
    {
        $bandLeader = $band->getLeader();
        $contacts = $bandLeader ? [$bandLeader->getEmail()] : [...[$bandLeader->getEmail()], ...array_map(fn ($user) => $user->getEmail(), $this->userRepository->findBy([], [], 5))];

        $emailMessage = (new TemplatedEmail())
            ->to(...$contacts)
            ->from($this->parameterBag->get('mailer_from'))
            ->from($dataMessage['email'])
            ->subject("Contact pour {$band->getName()}")
            ->htmlTemplate('_include/_MailContact.html.twig')
            ->context([
                'user' => $band->getLeader(),
                'dataMessage' => $dataMessage,
            ]);

        $this->mailer->send($emailMessage);
    }
}
