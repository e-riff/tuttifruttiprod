<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Application\Port\Notification\ContactMessageSenderInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Doctrine\Entity\Band;
use App\Infrastructure\Doctrine\Entity\Musician;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;

readonly class MailerService implements ContactMessageSenderInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private UserRepositoryInterface $userRepository,
        #[Autowire('%mailer_from%')]
        private string $mailerFrom,
    ) {
    }

    public function sendContactMail(array $dataMessage = []): void
    {
        $admins = $this->userRepository->findBy(criteria: [], limit: 5);
        $email = (new TemplatedEmail())
            ->to(...array_map(fn ($admin) => $admin->getEmail(), $admins))
            ->from($this->mailerFrom)
            ->subject('Nouveau message pour Tutti Frutti Pro')
            ->htmlTemplate('_include/_MailContact.html.twig')
            ->context([
                'dataMessage' => $dataMessage,
            ]);
        $this->mailer->send($email);
    }

    public function sendContactMailForBand(Band $band, array $dataMessage = []): void
    {
        $bandLeader = $band->getLeader();
        $contacts = [];

        if ($bandLeader instanceof Musician && $bandLeader->getEmail()) {
            $contacts[] = $bandLeader->getEmail();
        }

        if (!$contacts) {
            foreach ($this->userRepository->findBy(criteria: [], limit: 5) as $user) {
                $contacts[] = $user->getEmail();
            }
        }

        $contacts = array_values(array_filter($contacts));

        $emailMessage = (new TemplatedEmail())
            ->to(...$contacts)
            ->from($this->mailerFrom)
            ->replyTo($dataMessage['email'])
            ->subject("Contact pour {$band->getName()}")
            ->htmlTemplate('_include/_MailContact.html.twig')
            ->context([
                'user' => $band->getLeader(),
                'band' => $band,
                'dataMessage' => $dataMessage,
            ]);

        $this->mailer->send($emailMessage);
    }
}
