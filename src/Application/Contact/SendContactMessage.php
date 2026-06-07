<?php

declare(strict_types=1);

namespace App\Application\Contact;

use App\Application\Port\Notification\ContactMessageSenderInterface;

final readonly class SendContactMessage
{
    public function __construct(private ContactMessageSenderInterface $contactMessageSender)
    {
    }

    /**
     * @param array<string, mixed> $dataMessage
     */
    public function __invoke(array $dataMessage): void
    {
        $this->contactMessageSender->sendContactMail($dataMessage);
    }
}
