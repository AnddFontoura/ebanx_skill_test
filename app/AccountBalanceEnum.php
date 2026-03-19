<?php

namespace App;

use ValueError;

enum AccountBalanceEnum: int
{
    case deposit = 1;
    case withdraw = 2;
    case transfer = 3;

    public static function tryFromName(string $name): ?self
    {
        return defined(self::class . '::' . $name)
            ? constant(self::class . '::' . $name)
            : null;
    }

    public static function fromName(string $name): self
    {
        $enum = self::tryFromName($name);

        if (!$enum) {
            throw new ValueError("Invalid enum name [$name]");
        }

        return $enum;
    }
}
