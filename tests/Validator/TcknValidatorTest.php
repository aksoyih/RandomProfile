<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Tests\Validator;

use Aksoyih\RandomProfile\Exception\InvalidTcknException;
use Aksoyih\RandomProfile\Validator\TcknValidator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TcknValidatorTest extends TestCase
{
    #[Test]
    public function testGeneratesValidTckn(): void
    {
        $tckn = TcknValidator::generate();
        $this->assertTrue(TcknValidator::validate($tckn));
        $this->assertMatchesRegularExpression('/^[1-9]\d{10}$/', $tckn);
    }

    #[Test]
    public function testValidateAcceptsValidTckn(): void
    {
        $this->assertTrue(TcknValidator::validate('10000000146'));
    }

    #[Test]
    public function testValidateRejectsInvalidLength(): void
    {
        $this->expectException(InvalidTcknException::class);
        TcknValidator::validate('1234567890'); // 10 digits
    }

    #[Test]
    public function testValidateRejectsStartingWithZero(): void
    {
        $this->expectException(InvalidTcknException::class);
        TcknValidator::validate('01234567890');
    }

    #[Test]
    public function testMultipleGeneratedTcknsAreUnique(): void
    {
        $tckns = array_map(
            fn () => TcknValidator::generate(),
            range(1, 100)
        );

        $uniqueTckns = array_unique($tckns);
        $this->assertCount(100, $uniqueTckns);
    }
}