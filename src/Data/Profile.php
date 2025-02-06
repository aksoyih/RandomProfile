<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use Aksoyih\RandomProfile\Enum\Gender;
use Aksoyih\RandomProfile\Enum\MaritalStatus;
use DateTimeImmutable;
use JsonSerializable;

final class Profile implements JsonSerializable
{
    /**
     * @param array<string, string|null> $titles
     * @param array<string, string|array<string, string>> $miscellaneous
     * @param array<string, string> $networkInfo
     * @param array<string, mixed> $maritalInfo
     * @param array<int, array<string, mixed>> $children
     * @param array<string, string> $images
     */
    public function __construct(
        private readonly Gender $gender,
        private readonly string $name,
        private readonly string $surname,
        private readonly string $tckn,
        private readonly string $serialNumber,
        private readonly DateTimeImmutable $birthdate,
        private readonly int $age,
        private readonly array $titles,
        private readonly string $email,
        private readonly PhoneInfo $phone,
        private readonly LoginCredentials $loginCredentials,
        private readonly array $miscellaneous,
        private readonly array $networkInfo,
        private readonly array $maritalInfo,
        private readonly array $children,
        private readonly AddressInfo $address,
        private readonly BankAccount $bankAccount,
        private readonly array $images,
        private readonly ?Job $job,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'gender' => $this->gender->value,
            'name' => $this->name,
            'surname' => $this->surname,
            'tckn' => $this->tckn,
            'serialNumber' => $this->serialNumber,
            'birthdate' => $this->birthdate->format('Y-m-d'),
            'age' => $this->age,
            'titles' => $this->titles,
            'email' => $this->email,
            'phone' => $this->phone->jsonSerialize(),
            'loginCredentials' => $this->loginCredentials->jsonSerialize(),
            'miscellaneous' => $this->miscellaneous,
            'networkInfo' => $this->networkInfo,
            'maritalInfo' => $this->maritalInfo,
            'children' => [
                'count' => count($this->children),
                'children' => $this->children,
            ],
            'address' => $this->address->jsonSerialize(),
            'bankAccount' => $this->bankAccount->jsonSerialize(),
            'images' => $this->images,
            'job' => $this->job ? $this->job->jsonSerialize() : null,
        ];
    }
}