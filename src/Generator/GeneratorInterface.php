<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

interface GeneratorInterface
{
    public function generate(): mixed;
}