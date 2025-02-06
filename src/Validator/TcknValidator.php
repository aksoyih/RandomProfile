<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Validator;

use Aksoyih\RandomProfile\Exception\InvalidTcknException;

final class TcknValidator
{
    public static function validate(string $tckn): bool
    {
        if (!preg_match('/^[1-9]\d{10}$/', $tckn)) {
            throw new InvalidTcknException('TCKN must be 11 digits and cannot start with 0');
        }

        $digits = array_map('intval', str_split($tckn));
        
        // First digit cannot be 0
        if ($digits[0] === 0) {
            throw new InvalidTcknException('TCKN cannot start with 0');
        }

        // Check 10th digit algorithm
        $digit10 = ((($digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8]) * 7) 
                    - ($digits[1] + $digits[3] + $digits[5] + $digits[7])) % 10;
        
        if ($digit10 !== $digits[9]) {
            throw new InvalidTcknException('Invalid TCKN: 10th digit check failed');
        }

        // Check 11th digit algorithm
        $sum = array_sum(array_slice($digits, 0, 10));
        if ($sum % 10 !== $digits[10]) {
            throw new InvalidTcknException('Invalid TCKN: 11th digit check failed');
        }

        return true;
    }

    public static function generate(): string
    {
        $digits = [];
        // First digit cannot be 0
        $digits[] = random_int(1, 9);
        
        // Generate digits 2-9
        for ($i = 1; $i < 9; $i++) {
            $digits[] = random_int(0, 9);
        }

        // Calculate 10th digit
        $digit10 = ((($digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8]) * 7) 
                    - ($digits[1] + $digits[3] + $digits[5] + $digits[7])) % 10;
        $digits[] = $digit10;

        // Calculate 11th digit
        $sum = array_sum($digits);
        $digit11 = $sum % 10;
        $digits[] = $digit11;

        $tckn = implode('', $digits);
        self::validate($tckn);

        return $tckn;
    }
}