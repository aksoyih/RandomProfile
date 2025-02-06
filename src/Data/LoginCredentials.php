<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use DateTimeImmutable;
use JsonSerializable;

final class LoginCredentials implements JsonSerializable
{
    public function __construct(
        private readonly string $username,
        private readonly string $email,
        private readonly string $password,
        private readonly string $salt,
        private readonly string $hash,
        private readonly string $md5,
        private readonly string $sha1,
        private readonly string $sha256,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'salt' => $this->salt,
            'hash' => $this->hash,
            'md5' => $this->md5,
            'sha1' => $this->sha1,
            'sha256' => $this->sha256,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }
}