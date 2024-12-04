<?php

namespace App\Enums;

enum ChatStatus: string
{
    case CREATED = 'created';
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case CLOSED = 'closed';

    public static function defaultStatus(): self
    {
        return self::PENDING;
    }

    public static function initialStatus(): self
    {
        return self::CREATED;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
