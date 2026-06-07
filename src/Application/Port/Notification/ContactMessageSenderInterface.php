<?php

declare(strict_types=1);

namespace App\Application\Port\Notification;

use App\Infrastructure\Doctrine\Entity\Band;

interface ContactMessageSenderInterface
{
    /**
     * @param array<string, mixed> $dataMessage
     */
    public function sendContactMail(array $dataMessage = []): void;

    /**
     * @param array<string, mixed> $dataMessage
     */
    public function sendContactMailForBand(Band $band, array $dataMessage = []): void;
}
