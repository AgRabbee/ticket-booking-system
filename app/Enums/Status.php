<?php

namespace App\Enums;

enum Status: int
{
    case PENDING = 0;
    case ACTIVE = 1;
    case DENIED = 2;

    public static function fromRoute(string $status): ?self
    {
        return match (strtolower($status)) {
            'active' => self::ACTIVE,
            'pause'  => self::PENDING,
            'deny'   => self::DENIED,
            default  => null,
        };
    }
}
