<?php

namespace App\Domain;

enum JapaneseCoins :int
{
    case One = 1;
    case Five = 5;
    case Ten = 10;
    case Fifty = 50;
    case OneHundred = 100;
    case FiveHundred = 500;

    public static function of(int $value): JapaneseCoins {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        throw new \InvalidArgumentException('Invalid ResourceState');
    }
}
