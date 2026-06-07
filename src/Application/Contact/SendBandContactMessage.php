<?php

declare(strict_types=1);

namespace App\Application\Contact;

use App\Application\Port\Notification\ContactMessageSenderInterface;
use App\Infrastructure\Doctrine\Entity\Band;

final readonly class SendBandContactMessage
{
    public function __construct(private ContactMessageSenderInterface $contactMessageSender)
    {
    }

    /**
     * @param array<string, mixed> $dataMessage
     */
    public function __invoke(Band $band, array $dataMessage): void
    {
        $this->contactMessageSender->sendContactMailForBand($band, $dataMessage);
    }
}
