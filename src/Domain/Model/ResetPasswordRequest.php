<?php

declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeInterface;

class ResetPasswordRequest
{
    private ?int $id = null;

    private ?User $user = null;

    private DateTimeInterface $expiresAt;

    private string $selector;

    private string $hashedToken;

    private DateTimeInterface $requestedAt;

    public function __construct(User $user, DateTimeInterface $expiresAt, string $selector, string $hashedToken, DateTimeInterface $requestedAt)
    {
        $this->user = $user;
        $this->expiresAt = $expiresAt;
        $this->selector = $selector;
        $this->hashedToken = $hashedToken;
        $this->requestedAt = $requestedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getExpiresAt(): DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function getHashedToken(): string
    {
        return $this->hashedToken;
    }

    public function getRequestedAt(): DateTimeInterface
    {
        return $this->requestedAt;
    }
}
