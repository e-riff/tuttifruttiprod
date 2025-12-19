<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Band;
use App\Entity\Musician;
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

        if ($bandLeader instanceof Musician) {
            $contacts[] = $bandLeader->getEmail();
        } else {
            foreach ($this->userRepository->findBy(criteria: [], limit: 5) as $user) {
                $contacts[] = $user->getEmail();
            }
        }

        $emailMessage = (new TemplatedEmail())
            ->to(...$contacts)
            ->from($this->parameterBag->get('mailer_from'))
            ->replyTo($dataMessage['email'])
            ->subject("Contact pour {$band->getName()}")
            ->htmlTemplate('_include/_MailContact.html.twig')
            ->context([
                'user' => $band->getLeader(),
                'dataMessage' => $dataMessage,
            ]);

        $this->mailer->send($emailMessage);
    }
}
